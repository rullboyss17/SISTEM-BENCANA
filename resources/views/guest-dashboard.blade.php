<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENKORBAN - Dashboard Publik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e3c72;
            --secondary-color: #2a5298;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation */
        .top-navbar {
            background: rgba(30, 60, 114, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            text-decoration: none;
        }

        .navbar-brand i {
            font-size: 2rem;
            margin-right: 0.75rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            border-radius: 8px;
        }

        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Main Container */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .hero-container {
            max-width: 1000px;
            width: 100%;
        }

        .hero-header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* Cards */
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            padding: 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .feature-card:nth-child(1) .feature-icon {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .feature-card:nth-child(2) .feature-icon {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .feature-card:nth-child(1):hover .feature-icon {
            background: #3498db;
            color: white;
            transform: scale(1.1);
        }

        .feature-card:nth-child(2):hover .feature-icon {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.75rem;
        }

        .feature-desc {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .feature-link {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .feature-link:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Info Section */
        .info-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            color: white;
            margin-top: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
        }

        .info-list i {
            margin-right: 0.75rem;
            color: #4dd0e1;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.3);
            color: white;
            padding: 2rem;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Notification Bell */
        .notification-bell {
            position: relative;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-bell:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--danger-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .top-navbar {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-navbar">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <i class="fas fa-life-ring"></i>
                <span>SIPENKORBAN</span>
            </a>
            
            <div class="navbar-actions">
                <button class="notification-bell" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="notification-badge" id="notif-count" style="display: none;">0</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="width:300px;max-height:400px;overflow-y:auto;">
                    <li class="dropdown-header fw-bold">Laporan Terbaru</li>
                    <li><hr class="dropdown-divider"></li>
                    <div id="notification-list">
                        <li class="px-3 py-2 text-muted text-center text-sm">Memuat...</li>
                    </div>
                </ul>

                <a href="{{ route('login') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="hero-container">
            <!-- Header -->
            <div class="hero-header">
                <h1 class="hero-title">Sistem Pendataan Korban Bencana</h1>
                <p class="hero-subtitle">Laporkan dan pantau situasi bencana secara real-time</p>
            </div>

            <!-- Feature Cards -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="feature-card" onclick="location.href='{{ route('quick-report.create') }}'">
                        <div class="feature-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <h3 class="feature-title">Lapor Cepat</h3>
                        <p class="feature-desc">Laporkan kejadian bencana dengan foto dan informasi lokasi</p>
                        <a href="{{ route('quick-report.create') }}" class="feature-link">
                            Buat Laporan <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <h5 class="info-title"><i class="fas fa-info-circle me-2"></i>Apa yang dapat Anda lakukan?</h5>
                <ul class="info-list">
                    <li><i class="fas fa-check-circle"></i> Membuat laporan cepat kejadian bencana dengan foto</li>
                    <li><i class="fas fa-check-circle"></i> Melihat notifikasi laporan terbaru</li>
                    <li><i class="fas fa-check-circle"></i> <a href="{{ route('login') }}" style="color: #4dd0e1; text-decoration: none;">Login untuk akses penuh</a> sebagai petugas</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <strong>SIPENKORBAN v2.0</strong> &copy; 2023 BNPB - Sistem Pendataan Korban Bencana
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const notificationBadge = document.getElementById('notif-count');
        const notificationList = document.getElementById('notification-list');

        async function loadNotifications() {
            try {
                const res = await fetch("{{ route('notifications.quick-reports') }}", {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const data = await res.json();
                
                notificationBadge.textContent = data.count;
                if (data.count > 0) {
                    notificationBadge.style.display = 'flex';
                } else {
                    notificationBadge.style.display = 'none';
                }
                
                if (data.reports.length === 0) {
                    notificationList.innerHTML = '<li class="px-3 py-2 text-muted text-center text-sm">Belum ada laporan</li>';
                } else {
                    notificationList.innerHTML = data.reports.map(report => {
                    notificationList.innerHTML = data.reports.map(report => {
                        const date = new Date(report.created_at);
                        const timeAgo = getTimeAgo(date);
                        return `
                            <li>
                                <div class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-circle text-danger me-2 mt-1"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold text-dark">${report.lokasi}</div>
                                            <small class="text-muted">${report.jumlah_korban} korban • ${timeAgo}</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider m-0"></li>
                        `;
                    }).join('');
                }ch (e) {
                console.warn('Error loading notifications', e);
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

        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            setInterval(loadNotifications, 10000);
        });
    </script>
</body>
</html>
