<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Rekap Pelanggaran Siswa</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- App Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="brand-name">SISWA CARE</span>
            </div>

            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('students.*') ? 'active' : '' }}">
                    <a href="{{ route('students.index') }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('violations.*') ? 'active' : '' }}">
                    <a href="{{ route('violations.index') }}">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Jenis Pelanggaran</span>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('logs.*') ? 'active' : '' }}">
                    <a href="{{ route('logs.index') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Laporan Pelanggaran</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="admin-profile">
                    <div class="admin-avatar">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="admin-info">
                        <span class="admin-name">Administrator</span>
                        <span class="admin-role">Guru BK</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div class="page-title">
                    <h1>@yield('page_title', 'Dashboard')</h1>
                    <p>@yield('page_subtitle', 'Selamat datang di Sistem Rekap Pelanggaran Siswa.')</p>
                </div>
                <div class="header-actions">
                    <div class="time-widget" style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">
                        <i class="fa-regular fa-calendar-days" style="margin-right: 0.5rem; color: var(--accent-color);"></i>
                        <span id="current-date"></span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Yield -->
            @yield('content')
        </main>
    </div>

    <!-- Script to update date -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateSpan = document.getElementById('current-date');
            if (dateSpan) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const today  = new Date();
                dateSpan.textContent = today.toLocaleDateString('id-ID', options);
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
