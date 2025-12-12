<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korban;

class MatchingController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $searchQuery = $request->get('search', '');
        $statusFilter = $request->get('status', '');
        $sortBy = $request->get('sort', 'similarity');

        // Get korban hilang dan ditemukan
        $korbanHilang = Korban::where('status', 'hilang')
            ->when($searchQuery, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                      ->orWhere('alamat', 'like', "%$search%")
                      ->orWhere('lokasi', 'like', "%$search%")
                      ->orWhere('keterangan', 'like', "%$search%");
                });
            })
            ->get();

        // Korban ditemukan: ikutkan status "ditemukan" dan juga "selamat" supaya korban yang sudah diselamatkan tetap muncul sebagai kandidat bila belum dikonfirmasi
        $korbanDitemukan = Korban::whereIn('status', ['ditemukan', 'selamat'])
            ->when($searchQuery, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                      ->orWhere('alamat', 'like', "%$search%")
                      ->orWhere('lokasi', 'like', "%$search%")
                      ->orWhere('keterangan', 'like', "%$search%");
                });
            })
            ->get();

        // Perform matching with similarity scoring
        $matches = [];
        foreach ($korbanHilang as $hilang) {
            foreach ($korbanDitemukan as $ditemukan) {
                $similarity = $this->calculateSimilarity($hilang, $ditemukan);
                
                if ($similarity > 0) {
                    $matches[] = [
                        'hilang' => $hilang,
                        'ditemukan' => $ditemukan,
                        'similarity' => $similarity,
                        'confidence' => $this->getConfidenceLevel($similarity)
                    ];
                }
            }
        }

        // Sort matches
        if ($sortBy === 'similarity') {
            usort($matches, function($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });
        }

        // Filter by status if needed
        if ($statusFilter) {
            $matches = array_filter($matches, function($match) use ($statusFilter) {
                return $match['confidence'] === $statusFilter;
            });
        }

        return view('matching.index', compact('matches', 'korbanHilang', 'korbanDitemukan', 'searchQuery', 'statusFilter'));
    }

    private function calculateSimilarity($hilang, $ditemukan)
    {
        $score = 0;
        
        // Name similarity (40 points max)
        $nameSimilarity = $this->stringSimilarity($hilang->nama, $ditemukan->nama);
        $score += $nameSimilarity * 40;
        
        // Age similarity (20 points max)
        if ($hilang->usia && $ditemukan->usia) {
            $ageDiff = abs($hilang->usia - $ditemukan->usia);
            if ($ageDiff === 0) {
                $score += 20;
            } elseif ($ageDiff <= 2) {
                $score += 15;
            } elseif ($ageDiff <= 5) {
                $score += 10;
            }
        }
        
        // Gender match (15 points max)
        if ($hilang->jenis_kelamin === $ditemukan->jenis_kelamin) {
            $score += 15;
        }
        
        // Location similarity (15 points max)
        if ($hilang->lokasi && $ditemukan->lokasi) {
            $locationSimilarity = $this->stringSimilarity($hilang->lokasi, $ditemukan->lokasi);
            $score += $locationSimilarity * 15;
        }
        
        // Description/Keterangan similarity (10 points max)
        if ($hilang->keterangan && $ditemukan->keterangan) {
            $descSimilarity = $this->stringSimilarity($hilang->keterangan, $ditemukan->keterangan);
            $score += $descSimilarity * 10;
        }
        
        return round($score, 2);
    }

    private function stringSimilarity($str1, $str2)
    {
        if (empty($str1) || empty($str2)) {
            return 0;
        }
        
        $str1 = strtolower(trim($str1));
        $str2 = strtolower(trim($str2));
        
        // Exact match
        if ($str1 === $str2) {
            return 1;
        }
        
        // Levenshtein distance
        $maxLen = max(strlen($str1), strlen($str2));
        if ($maxLen === 0) {
            return 1;
        }
        
        $distance = levenshtein($str1, $str2);
        $similarity = 1 - ($distance / $maxLen);
        
        return max(0, $similarity);
    }

    private function getConfidenceLevel($similarity)
    {
        if ($similarity >= 75) {
            return 'high';
        } elseif ($similarity >= 50) {
            return 'medium';
        } elseif ($similarity >= 25) {
            return 'low';
        }
        return 'very-low';
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'hilang_id' => 'required|exists:korbans,id',
            'ditemukan_id' => 'required|exists:korbans,id',
        ]);

        $hilang = Korban::findOrFail($request->hilang_id);
        $ditemukan = Korban::findOrFail($request->ditemukan_id);

        // Update status to 'selamat' for both
        $hilang->update(['status' => 'selamat']);
        $ditemukan->update(['status' => 'selamat']);

        return redirect()->route('matching.index')
            ->with('success', 'Matching berhasil dikonfirmasi! Status korban telah diupdate menjadi Selamat.');
    }
}

