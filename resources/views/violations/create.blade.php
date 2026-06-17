@extends('layouts.app')

@section('title', 'Tambah Jenis Pelanggaran Baru')
@section('page_title', 'Tambah Jenis Pelanggaran')
@section('page_subtitle', 'Masukkan jenis pelanggaran baru beserta bobot poin sanksi.')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-plus" style="color: var(--accent-color);"></i>
                    Formulir Jenis Pelanggaran
                </h3>
                <a href="{{ route('violations.index') }}" class="btn btn-secondary btn-sm">Batal</a>
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

            <form action="{{ route('violations.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nama / Deskripsi Pelanggaran</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Terlambat masuk sekolah, Merusak sarana sekolah" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Kategori</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="">-- Pilih Kategori Pelanggaran --</option>
                        <option value="Ringan" {{ old('category') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="Sedang" {{ old('category') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Berat" {{ old('category') == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="points" class="form-label">Bobot Sanksi (Poin)</label>
                    <input type="number" id="points" name="points" value="{{ old('points', 5) }}" min="1" max="100" class="form-control" required>
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Masukkan angka antara 1 dan 100. Poin ini akan diakumulasikan ke pelanggar.</span>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Pelanggaran
                    </button>
                    <a href="{{ route('violations.index') }}" class="btn btn-secondary" style="flex: 1;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
