<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Pendataan Korban Bencana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0c224a;
            --secondary-color: #2a5298;
            --danger-color: #4f141a;
            --warning-color: #ffc107;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --sidebar-width: 260px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            overflow: hidden;
        }

        /* Modern Cards */
        .stats-card,
        .disaster-table-card,
        .priority-card,
        .progress-chart-card,
        .emergency-contact-card {
            border-radius: 14px !important;
            background: #ffffff;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 4px 10px rgba(0,0,0,.04) !important;
        }

        .stats-label {
            font-size: .85rem;
            color: #6b7280;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 3px;
            color: #1e3c72;
        }

        .stats-change {
            font-size: .8rem;
            margin-top: 3px;
        }

        .stats-icon-container {
            border-radius: 14px;
            width: 58px;
            height: 58px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.7rem;
            background: #eef2ff;
            color: #1e3c72;
        }

        /* Tables */
        .table thead {
            background: #f9fafb;
        }

        .table tbody tr:hover {
            background: #f3f4f6;
        }

        /* Quick Buttons */
        .quick-button {
            border-radius: 14px !important;
            font-weight: 600 !important;
            padding: 14px !important;
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center !important;
            box-shadow: 0 4px 10px rgba(0,0,0,.08) !important;
        }

        /* Progress bars */
        .progress {
            height: 10px !important;
            background-color: #e5e7eb !important;
            border-radius: 8px !important;
        }

        .progress-bar {
            border-radius: 8px !important;
        }

        /* Emergency Icons */
        .emergency-contact-card i {
            font-size: 1.9rem !important;
        }

        /* Badges */
        .badge {
            padding: 6px 10px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        /* Card improvements */
        .card {
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }

        .card-header {
            border-radius: 14px 14px 0 0 !important;
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* Main Layout Container */
        .layout-container {
            display: flex;
            height: 100%;
        }
        
        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 10px;
        }
        
        .system-name {
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.3;
        }
        
        .system-tagline {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        /* Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
        }
        
        .nav-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.6;
            font-weight: 600;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: rgba(255, 255, 255, 0.3);
        }
        
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
            font-weight: 600;
        }
        
        .nav-icon {
            width: 40px;
            font-size: 1.2rem;
            text-align: center;
        }
        
        .nav-text {
            flex-grow: 1;
            font-size: 0.95rem;
        }
        
        .nav-badge {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .nav-badge.urgent {
            background-color: var(--danger-color);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        /* User Profile in Sidebar */
        .user-profile {
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        
        .user-details {
            flex-grow: 1;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.1rem;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        .user-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--success-color);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        /* Top Navigation Bar */
        .top-nav {
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            flex-shrink: 0;
        }
        
        .breadcrumb {
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        
        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .top-nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .search-box {
            position: relative;
            width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 50px;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .notification-btn:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .quick-report-btn {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .quick-report-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
        }
        
        /* Page Content Area */
        .page-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            padding: 1.5rem;
            background-color: #f8f9fa;
        }

        /* Content Area for dynamic content */
        .content-area {
            flex: 1;
        }

        /* Scrollable Container */
        .scrollable-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        /* Content Area - Only this scrolls */
        .content-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
        }
        
        .page-header {
            margin-bottom: 1.5rem;
            flex-shrink: 0;
        }
        
        .page-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }
        
        .page-actions {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            flex-shrink: 0;
        }
        
        /* Footer */
        .main-footer {
            background-color: white;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            margin-left: 1rem;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        /* Toggle Sidebar Button */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .search-box {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .top-nav-actions {
                gap: 0.5rem;
            }
            
            .search-box {
                width: 150px;
            }
            
            .page-content {
                padding: 1rem;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .footer-links a {
                margin: 0 0.5rem;
            }
        }
        
        /* Alert Banner */
        .alert-banner {
            background: linear-gradient(90deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid var(--danger-color);
            padding: 0.75rem 1.5rem;
            margin-bottom: 0.25rem;
            border-radius: 0 8px 8px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .banner-fade {
            transition: opacity 0.35s ease;
        }

        .banner-fade.opacity-0 {
            opacity: 0;
        }
        
        .alert-content {
            display: flex;
            align-items: center;
        }
        
        .alert-icon {
            font-size: 1.5rem;
            color: var(--danger-color);
            margin-right: 1rem;
        }
        
        .alert-badge {
            background-color: var(--danger-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 1rem;
        }
        
        /* Guest user badge */
        .guest-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    <div>
                        <div class="system-name">SIPENKORBAN</div>
                        <div class="system-tagline">Sistem Pendataan Korban Bencana</div>
                    </div>
                </div>
            </div>
            
            <!-- User Profile / Guest Info -->
            <div class="user-profile">
                @auth
                    <div class="user-info">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div class="user-details">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">Petugas</div>
                        </div>
                        <div class="user-status"></div>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="user-name" style="margin-bottom: 0.5rem;">Pengunjung</div>
                            <span class="guest-badge">Akses Terbatas</span>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Login</a>
                    </div>
                @endauth
            </div>
            
            <nav class="sidebar-nav">
                @auth
                <!-- Menu Petugas -->
                <div class="nav-section">
                    <div class="nav-section-title">Menu Petugas</div>
                    
                    <a href="{{ route('dashboard') }}" class="nav-item @if(request()->routeIs('dashboard')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div class="nav-text">Dashboard</div>
                    </a>
                    
                    <a href="{{ route('laporan-harian.index') }}" class="nav-item @if(request()->routeIs('laporan-harian.*')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="nav-text">Laporan Harian</div>
                    </a>
                    
                    <a href="{{ route('korban.index') }}" class="nav-item @if(request()->routeIs('korban.*')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="nav-text">Data Korban</div>
                    </a>
                    
                    <a href="{{ route('matching.index') }}" class="nav-item @if(request()->routeIs('matching.index')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="nav-text">Matching Korban</div>
                    </a>
                    
                    <a href="{{ route('disasters.dashboard') }}" class="nav-item @if(request()->routeIs('disasters.dashboard')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-mountain"></i>
                        </div>
                        <div class="nav-text">Data Bencana</div>
                    </a>

                    <a href="{{ route('posko.index') }}" class="nav-item @if(request()->routeIs('posko.index')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                        <div class="nav-text">Data Posko</div>
                    </a>
                    <a href="{{ route('surat.index') }}" class="nav-item @if(request()->routeIs('surat.*')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="nav-text">Halaman Surat</div>
                    </a>
                </div>
                
                <!-- Data Entry -->
                <div class="nav-section">
                    <div class="nav-section-title">Entry Data</div>
                    
                    <a href="{{ route('korban.create') }}" class="nav-item @if(request()->routeIs('korban.create')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="nav-text">Tambah Korban</div>
                    </a>
                    
                    <a href="{{ route('bencana.create') }}" class="nav-item @if(request()->routeIs('bencana.create')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="nav-text">Tambah Bencana</div>
                    </a>
                    
                    <a href="{{ route('import.index') }}" class="nav-item @if(request()->routeIs('import.*')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-file-import"></i>
                        </div>
                        <div class="nav-text">Import Data</div>
                    </a>
                </div>
                
                <!-- Settings -->
                <div class="nav-section">
                    <div class="nav-section-title">Pengaturan</div>
                    
                    <a href="{{ route('settings.index') }}" class="nav-item @if(request()->routeIs('settings.index') || request()->routeIs('users.index')) active @endif">
                        <div class="nav-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="nav-text">Pengaturan</div>
                    </a>
                </div>
                @endauth
            </nav>
            
        </aside>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <header class="top-nav">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Cari korban, bencana...">
                    </div>
                </div>
                
                <div class="top-nav-actions">
                    @auth
                    <div class="dropdown">
                        <button class="notification-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <span class="notification-badge" id="notif-count">0</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="width:320px;max-height:400px;overflow-y:auto;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Laporan Cepat Terbaru</span>
                                <a href="{{ route('laporan-harian.index') }}" class="badge bg-primary text-decoration-none">Lihat Semua</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <div id="notification-list">
                                <li class="px-3 py-2 text-muted text-center">Memuat notifikasi...</li>
                            </div>
                        </ul>
                    </div>
                    @endauth
                    
                    <a class="quick-report-btn" href="{{ route('quick-report.create') }}">
                        <i class="fas fa-plus-circle me-2"></i>
                        Lapor Cepat
                    </a>

                    @auth
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
                    @endauth
                </div>
            </header>
            
            <!-- Alert Banner -->
            @auth
            <div class="alert-banner">
                <div class="alert-content">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    <div>
                        <strong>Bencana Aktif:</strong>
                        <span id="layout-banner-text" class="banner-fade">Memuat data bencana...</span>
                    </div>
                </div>
            </div>
            @endauth
            
            <!-- Page Content -->
            <main class="page-content">
                <!-- Page Actions -->
                @auth
                <div class="page-actions" style="margin-top: -0.5rem; margin-bottom: 0.25rem; gap: 0.5rem;">
                    <a href="{{ route('export.index') }}" class="btn btn-sm btn-outline-primary" title="Export Data">
                        <i class="fas fa-download"></i>
                        <span class="d-none d-sm-inline ms-1">Export</span>
                    </a>
                    
                    <a href="{{ route('laporan-harian.print') }}" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1" title="Cetak Laporan">
                        <i class="fas fa-print"></i>
                        <span class="d-none d-sm-inline">Cetak</span>
                    </a>
                    
                    <button id="btn-refresh" type="button" class="btn btn-sm btn-outline-warning" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                        <span class="d-none d-sm-inline ms-1">Refresh</span>
                    </button>
                    
                    <a href="{{ route('help.index') }}" class="btn btn-sm btn-outline-info" title="Bantuan">
                        <i class="fas fa-question-circle"></i>
                        <span class="d-none d-sm-inline ms-1">Bantuan</span>
                    </a>
                </div>
                @endauth
                
                <!-- Scrollable Content -->
                <div class="scrollable-container">
                    <!-- Content Area -->
                    <div class="content-area">
                        @yield('content')
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="main-footer">
                    <div class="footer-content">
                        <div>
                            <strong>SIPENKORBAN v2.0</strong> &copy; 2023 BNPB - Sistem Pendataan Korban Bencana
                        </div>
                        <div class="footer-links">
                            <a href="#">Kebijakan Privasi</a>
                            <a href="#">Syarat Penggunaan</a>
                            <a href="#">Bantuan</a>
                            <a href="#">Kontak</a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isMobile = window.innerWidth <= 992;
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);
            
            if (isMobile && !isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
        
        // Active nav item highlight
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('show');
                }
            });
        });
        
        // Notification system
        const notificationBadge = document.getElementById('notif-count');
        const notificationList = document.getElementById('notification-list');

        async function loadNotifications() {
            try {
                const res = await fetch("{{ route('notifications.quick-reports') }}", {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const data = await res.json();
                
                // Update badge count
                notificationBadge.textContent = data.count;
                if (data.count > 0) {
                    notificationBadge.style.display = 'flex';
                } else {
                    notificationBadge.style.display = 'none';
                }
                
                // Update notification list
                if (data.reports.length === 0) {
                    notificationList.innerHTML = '<li class="px-3 py-2 text-muted text-center">Belum ada laporan</li>';
                } else {
                    notificationList.innerHTML = data.reports.map(report => {
                        const date = new Date(report.created_at);
                        const timeAgo = getTimeAgo(date);
                        return `
                            <li>
                                <a class="dropdown-item" href="{{ route('laporan-harian.index') }}">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-circle text-danger me-2 mt-1"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">${report.lokasi}</div>
                                            <small class="text-muted">${report.jumlah_korban} korban • ${timeAgo}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider m-0"></li>
                        `;
                    }).join('');
                }
            } catch (e) {
                console.warn('Gagal memuat notifikasi', e);
            }
        }

        function getTimeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            if (seconds < 60) return 'baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} menit lalu`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} jam lalu`;
            const days = Math.floor(hours / 24);
            return `${days} hari lalu`;
        }
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();
                    if (query.length > 0) {
                        const target = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                        window.location.href = target;
                    }
                }
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
                        // Refresh Data button
                        const refreshBtn = document.getElementById('btn-refresh');
                        if (refreshBtn) {
                            refreshBtn.addEventListener('click', () => window.location.reload());
                        }
            // Load notifications on page load
            loadNotifications();
            
            // Refresh notifications every 10 seconds
            setInterval(loadNotifications, 10000);
            
            // Notification pulse animation
            setInterval(() => {
                if (notificationBadge && notificationBadge.textContent !== '0') {
                    notificationBadge.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        notificationBadge.style.transform = 'scale(1)';
                    }, 300);
                }
            }, 5000);

            // Rotating banner for latest disasters (petugas only)
            @auth
            (function rotateBanner() {
                const textEl = document.getElementById('layout-banner-text');
                const linkEl = document.getElementById('layout-banner-link');
                if (!textEl) return;

                const baseUrl = '{{ url('bencana') }}';
                let items = [];
                let idx = 0;

                const show = (item) => {
                    textEl.classList.add('opacity-0');
                    setTimeout(() => {
                        textEl.textContent = item.text;
                        if (linkEl) {
                            linkEl.href = `${baseUrl}/${item.id}`;
                        }
                        textEl.classList.remove('opacity-0');
                    }, 250);
                };

                const refresh = async () => {
                    try {
                        const res = await fetch("{{ route('bencana.latest') }}", { headers: { 'Accept': 'application/json' }});
                        if (!res.ok) return;
                        const data = await res.json();
                        if (!Array.isArray(data) || data.length === 0) return;
                        items = data.map(d => ({ id: d.id, text: `${d.nama} - ${d.lokasi}` }));
                        idx = 0;
                        show(items[idx]);
                    } catch (e) {
                        console.warn('Gagal memuat bencana terbaru', e);
                    }
                };

                setInterval(() => {
                    if (items.length <= 1) return;
                    idx = (idx + 1) % items.length;
                    show(items[idx]);
                }, 4500);

                refresh();
                setInterval(refresh, 10000);
            })();
            @endauth
        });
    </script>
    @stack('scripts')
</body>
</html>
