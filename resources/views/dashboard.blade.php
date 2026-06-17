@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Tinjauan cepat rekap pelanggaran tata tertib siswa.')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Total Siswa</span>
                <span class="stat-value">{{ $totalStudents }}</span>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Jenis Pelanggaran</span>
                <span class="stat-value">{{ $totalViolationTypes }}</span>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Total Kasus</span>
                <span class="stat-value">{{ $totalIncidents }}</span>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-label">Total Poin Akumulasi</span>
                <span class="stat-value">{{ $totalPoints }}</span>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
        </div>
    </div>

    <!-- Main Grid Section -->
    <div class="dashboard-grid">
        <!-- Left Column: High Risk Students -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-circle-exclamation" style="color: var(--danger-color);"></i>
                    Siswa Poin Tertinggi (Peringatan BK)
                </h3>
                <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Semua Siswa</a>
            </div>
            
            @if($topStudents->isEmpty())
                <div style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                    <i class="fa-solid fa-circle-check" style="font-size: 2.5rem; color: var(--success-color); margin-bottom: 1rem;"></i>
                    <p>Tidak ada siswa dengan catatan pelanggaran saat ini. Pertahankan!</p>
                </div>
            @else
                <div class="risk-list">
                    @foreach($topStudents as $student)
                        @php
                            $ptClass = 'points-safe';
                            if ($student->points >= 50) $ptClass = 'points-danger';
                            elseif ($student->points >= 20) $ptClass = 'points-warn';
                        @endphp
                        <div class="risk-item">
                            <div class="risk-avatar">
                                <span>{{ substr($student->name, 0, 1) }}</span>
                            </div>
                            <div class="risk-student-info">
                                <a href="{{ route('students.show', $student->id) }}" class="risk-name" style="text-decoration: underline; text-underline-offset: 4px;">{{ $student->name }}</a>
                                <div class="risk-class">
                                    <span>{{ $student->class }}</span>
                                    <span style="margin: 0 0.5rem;">•</span>
                                    <span>NISN: {{ $student->nisn }}</span>
                                </div>
                            </div>
                            <span class="points-tag {{ $ptClass }}" style="font-size: 1.1rem; padding: 0.35rem 0.75rem;">
                                {{ $student->points }} <span style="font-size: 0.75rem; font-weight: 500;">Poin</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column: Category & Class breakdown -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-chart-pie" style="color: var(--accent-color);"></i>
                    Sebaran Pelanggaran
                </h3>
            </div>
            
            <!-- Category Box Breakdown -->
            <div class="cat-stats-grid">
                <div class="cat-stat-box ringan">
                    <div class="cat-stat-title">Ringan</div>
                    <div class="cat-stat-val" style="color: var(--success-color)">{{ $categoryChartData['Ringan']['count'] }}</div>
                </div>
                <div class="cat-stat-box sedang">
                    <div class="cat-stat-title">Sedang</div>
                    <div class="cat-stat-val" style="color: var(--warning-color)">{{ $categoryChartData['Sedang']['count'] }}</div>
                </div>
                <div class="cat-stat-box berat">
                    <div class="cat-stat-title">Berat</div>
                    <div class="cat-stat-val" style="color: var(--danger-color)">{{ $categoryChartData['Berat']['count'] }}</div>
                </div>
            </div>

            <!-- Class Point Chart -->
            <h4 style="font-size: 0.9rem; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 1rem; letter-spacing: 0.5px;">Akumulasi Poin per Kelas</h4>
            @if($classStats->isEmpty() || $totalPoints == 0)
                <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 1.5rem;">Belum ada data untuk ditampilkan.</p>
            @else
                <div class="class-chart-list">
                    @php
                        $maxPoints = $classStats->max('total_points') ?: 1;
                    @endphp
                    @foreach($classStats as $class)
                        @if($class->total_points > 0)
                            @php
                                $percent = ($class->total_points / $maxPoints) * 100;
                            @endphp
                            <div class="class-chart-item">
                                <div class="class-chart-info">
                                    <span>{{ $class->class }}</span>
                                    <span>{{ $class->total_points }} Poin</span>
                                </div>
                                <div class="class-chart-bar-container">
                                    <div class="class-chart-bar" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Logs Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fa-solid fa-clock-rotate-left" style="color: var(--accent-color);"></i>
                Laporan Kasus Terbaru
            </h3>
            <a href="{{ route('logs.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Catat Pelanggaran
            </a>
        </div>

        @if($recentIncidents->isEmpty())
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <i class="fa-regular fa-clipboard" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>Belum ada riwayat pelanggaran siswa yang tercatat.</p>
            </div>
        @else
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Pelanggaran</th>
                            <th>Kategori</th>
                            <th>Poin</th>
                            <th>Tanggal Laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentIncidents as $incident)
                            <tr>
                                <td>
                                    <a href="{{ route('students.show', $incident->student->id) }}" style="font-weight: 600; text-decoration: underline; text-underline-offset: 3px;">
                                        {{ $incident->student->name }}
                                    </a>
                                </td>
                                <td>{{ $incident->student->class }}</td>
                                <td>
                                    <div style="font-weight: 500;">{{ $incident->violation->name }}</div>
                                    @if($incident->description)
                                        <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.2rem;">
                                            "{{ $incident->description }}"
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower($incident->violation->category) }}">
                                        {{ $incident->violation->category }}
                                    </span>
                                </td>
                                <td>
                                    <span class="points-tag points-danger">{{ $incident->points }}</span>
                                </td>
                                <td>{{ $incident->reported_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('logs.destroy', $incident->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pelanggaran ini? Poin siswa akan dikurangi kembali.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger-color); border-color: rgba(244, 63, 94, 0.2); background: rgba(244, 63, 94, 0.03);">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
