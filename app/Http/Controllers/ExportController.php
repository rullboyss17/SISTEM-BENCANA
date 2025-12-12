<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use App\Models\Korban;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function disastersCsv()
    {
        $rows = Disaster::orderByDesc('created_at')->get();
        return $this->toCsvResponse($rows, 'disasters.csv');
    }

    public function korbanCsv()
    {
        $rows = Korban::orderByDesc('created_at')->get();
        return $this->toCsvResponse($rows, 'korban.csv');
    }

    private function toCsvResponse($rows, string $filename): Response
    {
        $csv = '';
        if ($rows->count() > 0) {
            $first = $rows->first();
            $headers = array_keys($first->getAttributes());
            $csv .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\n";
            foreach ($rows as $row) {
                $values = [];
                foreach ($headers as $key) {
                    $values[] = $this->escapeCsv((string)($row->{$key}));
                }
                $csv .= implode(',', $values) . "\n";
            }
        } else {
            $csv .= "data,tidak,tersedia\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function escapeCsv(string $value): string
    {
        $needsQuotes = strpbrk($value, ",\n\r\"") !== false;
        $escaped = str_replace('"', '""', $value);
        return $needsQuotes ? '"' . $escaped . '"' : $escaped;
    }
}
