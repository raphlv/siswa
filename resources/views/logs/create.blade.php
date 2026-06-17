@extends('layouts.app')

@section('title', 'Catat Pelanggaran Siswa')
@section('page_title', 'Catat Pelanggaran Baru')
@section('page_subtitle', 'Pilih siswa dan jenis pelanggaran untuk dicatatkan ke sistem.')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-file-signature" style="color: var(--accent-color);"></i>
                    Formulir Laporan Kasus
                </h3>
                <a href="{{ route('logs.index') }}" class="btn btn-secondary btn-sm">Batal</a>
            </div>

            <!-- Error Validation List -->
            @if ($errors->any())
                <div class="alert alert-danger" style="display: block; font-weight: normal;">
                    <strong style="display: block; margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan:</strong>
                    <ul style="padding-left: 1.5rem; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('logs.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="student_id" class="form-label">Nama Siswa</label>
                    <select id="student_id" name="student_id" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->class }}) - NISN: {{ $student->nisn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="violation_id" class="form-label">Jenis Pelanggaran</label>
                    <select id="violation_id" name="violation_id" class="form-control" required onchange="updatePointsPreview()">
                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                        @foreach($violations as $violation)
                            <option value="{{ $violation->id }}" data-points="{{ $violation->points }}" data-category="{{ $violation->category }}" {{ old('violation_id') == $violation->id ? 'selected' : '' }}>
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
                    <input type="date" id="reported_at" name="reported_at" class="form-control" value="{{ old('reported_at', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Keterangan Tambahan (Opsional)</label>
                    <textarea id="description" name="description" placeholder="Misal: Terlambat 15 menit, membawa rokok Marlboro 1 bungkus, dll." class="form-control">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">
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
        
        // Trigger preview on load if old value exists
        document.addEventListener('DOMContentLoaded', function() {
            updatePointsPreview();
        });
    </script>
@endsection
