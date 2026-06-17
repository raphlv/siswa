@extends('layouts.app')

@section('title', 'Detail Siswa: ' . $student->name)
@section('page_title', 'Detail Profil Siswa')
@section('page_subtitle', 'Tinjau riwayat pelanggaran dan catat kasus baru.')

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
        </a>
    </div>

    <!-- Student Info & Score Cards -->
    <div class="stats-grid" style="margin-bottom: 2.5rem;">
        <!-- Profile Card -->
        <div class="stat-card" style="grid-column: span 2; display: flex; align-items: center; justify-content: flex-start; gap: 1.5rem;">
            <div class="risk-avatar" style="width: 64px; height: 64px; font-size: 1.5rem; background: rgba(99, 102, 241, 0.08); border-color: rgba(99, 102, 241, 0.3); color: var(--accent-color);">
                <span>{{ substr($student->name, 0, 1) }}</span>
            </div>
            <div class="profile-details">
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $student->name }}</h2>
                <div style="color: var(--text-secondary); display: flex; gap: 1rem; font-size: 0.95rem;">
                    <span><strong>Kelas:</strong> {{ $student->class }}</span>
                    <span>•</span>
                    <span><strong>NISN:</strong> {{ $student->nisn }}</span>
                    <span>•</span>
                    <span><strong>Gender:</strong> {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
            </div>
        </div>

        <!-- Point Gauge Card -->
        @php
            $ptClass = 'points-safe';
            $statusText = 'Aman (Tingkat Pelanggaran Rendah)';
            $gaugeColor = 'var(--success-color)';
            if ($student->points >= 50) {
                $ptClass = 'points-danger';
                $statusText = 'Sanksi Keras (Peringatan / Drop Out)';
                $gaugeColor = 'var(--danger-color)';
            } elseif ($student->points >= 20) {
                $ptClass = 'points-warn';
                $statusText = 'Peringatan BK (Tindak Lanjut Diperlukan)';
                $gaugeColor = 'var(--warning-color)';
            }
        @endphp
        <div class="stat-card" style="border-left: 5px solid {{ $gaugeColor }};">
            <div class="stat-info">
                <span class="stat-label">Akumulasi Poin</span>
                <span class="stat-value {{ $ptClass }}">{{ $student->points }}</span>
                <span style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem;">{{ $statusText }}</span>
            </div>
            <div class="stat-icon" style="color: {{ $gaugeColor }};">
                <i class="fa-solid fa-gauge-high"></i>
            </div>
        </div>
    </div>

    <!-- Timeline & Log Violation Forms Grid -->
    <div class="dashboard-grid">
        <!-- Left: Violation History Timeline -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-clock-rotate-left" style="color: var(--accent-color);"></i>
                    Riwayat Pelanggaran
                </h3>
            </div>

            @if($student->studentViolations->isEmpty())
                <div style="text-align: center; padding: 4rem 2rem; color: var(--text-muted);">
                    <i class="fa-solid fa-circle-check" style="font-size: 3.5rem; color: var(--success-color); margin-bottom: 1.5rem;"></i>
                    <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">Siswa ini Sangat Teladan!</h4>
                    <p>Belum ada catatan pelanggaran tata tertib sekolah yang dilaporkan untuk siswa ini.</p>
                </div>
            @else
                <div class="history-timeline">
                    @foreach($student->studentViolations->sortByDesc('reported_at') as $sv)
                        @php $cat = strtolower($sv->violation->category); @endphp
                        <div class="history-item {{ $cat }}">
                            <div class="history-marker"></div>
                            <div class="history-details">
                                <div class="history-meta">
                                    <span><i class="fa-regular fa-calendar" style="margin-right: 0.25rem;"></i> {{ $sv->reported_at->format('d F Y') }}</span>
                                    <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                        <span class="badge badge-{{ $cat }}">{{ $sv->violation->category }}</span>
                                        <span class="points-tag points-danger" style="font-size: 0.8rem; padding: 0.15rem 0.4rem;">+{{ $sv->points }} Poin</span>
                                    </div>
                                </div>
                                <h4 class="history-title">{{ $sv->violation->name }}</h4>
                                @if($sv->description)
                                    <p class="history-desc">"{{ $sv->description }}"</p>
                                @endif
                                
                                <div style="display: flex; justify-content: flex-end; margin-top: 0.75rem;">
                                    <form action="{{ route('logs.destroy', $sv->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pelanggaran ini? Poin siswa akan dikurangi kembali.')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_to_student" value="1">
                                        <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger-color); border-color: rgba(244, 63, 94, 0.1); background: rgba(244, 63, 94, 0.02); font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                            <i class="fa-solid fa-trash-can"></i> Hapus Laporan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Log A Violation Form -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-plus" style="color: var(--accent-color);"></i>
                    Catat Kasus Baru
                </h3>
            </div>

            <form action="{{ route('logs.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="redirect_to_student" value="1">

                <div class="form-group">
                    <label for="violation_id" class="form-label">Jenis Pelanggaran</label>
                    <select id="violation_id" name="violation_id" class="form-control" required onchange="updatePointsPreview()">
                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                        @foreach($violations as $violation)
                            <option value="{{ $violation->id }}" data-points="{{ $violation->points }}" data-category="{{ $violation->category }}">
                                [{{ $violation->category }}] {{ $violation->name }} (+{{ $violation->points }} Poin)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Live Points Preview Box -->
                <div id="points-preview-box" style="display: none; margin-bottom: 1.5rem; padding: 1rem; border-radius: var(--radius-md); background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.9rem; color: var(--text-secondary);">Kategori & Bobot Poin:</span>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <span id="preview-category" class="badge"></span>
                            <span id="preview-points" class="points-tag points-danger" style="font-size: 0.95rem; font-weight: 700;"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reported_at" class="form-label">Tanggal Pelanggaran</label>
                    <input type="date" id="reported_at" name="reported_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Keterangan Tambahan (Opsional)</label>
                    <textarea id="description" name="description" placeholder="Misal: Terlambat 15 menit, rambut tidak dipotong saat disuruh kemarin, dll." class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    <i class="fa-solid fa-circle-check"></i> Catat Pelanggaran
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updatePointsPreview() {
            const select = document.getElementById('violation_id');
            const previewBox = document.getElementById('points-preview-box');
            const categorySpan = document.getElementById('preview-category');
            const pointsSpan = document.getElementById('preview-points');

            if (select.value === "") {
                previewBox.style.display = "none";
                return;
            }

            const selectedOption = select.options[select.selectedIndex];
            const points = selectedOption.getAttribute('data-points');
            const category = selectedOption.getAttribute('data-category');

            categorySpan.className = "badge badge-" + category.toLowerCase();
            categorySpan.textContent = category;
            pointsSpan.textContent = "+" + points + " Poin";

            previewBox.style.display = "block";
        }
    </script>
@endsection
