@extends('layouts.app')

@section('title', 'Edit Profil Siswa')
@section('page_title', 'Edit Profil Siswa')
@section('page_subtitle', 'Perbarui data profil siswa.')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fa-solid fa-pen-to-square" style="color: var(--accent-color);"></i>
                    Formulir Edit Siswa
                </h3>
                <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
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

            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nisn" class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" placeholder="Contoh: 0081234567" class="form-control" maxlength="10" required>
                    <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.25rem;">Harus berisi tepat 10 digit angka.</span>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" placeholder="Contoh: Aditya Pratama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="class" class="form-label">Kelas</label>
                    <input type="text" id="class" name="class" value="{{ old('class', $student->class) }}" placeholder="Contoh: XI IPA 1, X IPS 2" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui Data
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary" style="flex: 1;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
