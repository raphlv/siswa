@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')
@section('page_subtitle', 'Kelola data profil siswa dan pantau akumulasi poin pelanggaran.')

@section('content')
    <!-- Filter and Search Bar -->
    <div class="filter-bar">
        <form action="{{ route('students.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NISN..." class="form-control" style="width: 250px;">
            </div>
            
            <div class="filter-group">
                <select name="class" class="form-control" style="width: 180px;">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $classOpt)
                        <option value="{{ $classOpt }}" {{ request('class') == $classOpt ? 'selected' : '' }}>
                            {{ $classOpt }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'class']))
                <a href="{{ route('students.index') }}" class="btn btn-secondary" style="color: var(--text-muted);">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Tambah Siswa Baru
        </a>
    </div>

    <!-- Students Table -->
    <div class="section-card">
        @if($students->isEmpty())
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <i class="fa-solid fa-users-slash" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>Tidak ada data siswa ditemukan.</p>
            </div>
        @else
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>L/P</th>
                            <th>Akumulasi Poin</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $ptClass = 'points-safe';
                                if ($student->points >= 50) $ptClass = 'points-danger';
                                elseif ($student->points >= 20) $ptClass = 'points-warn';
                            @endphp
                            <tr>
                                <td style="font-family: monospace; font-size: 0.95rem; font-weight: 500;">
                                    {{ $student->nisn }}
                                </td>
                                <td>
                                    <a href="{{ route('students.show', $student->id) }}" style="font-weight: 600; text-decoration: underline; text-underline-offset: 3px;">
                                        {{ $student->name }}
                                    </a>
                                </td>
                                <td>{{ $student->class }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($student->gender) }}">
                                        {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="points-tag {{ $ptClass }}" style="font-size: 1rem; padding: 0.25rem 0.6rem;">
                                        {{ $student->points }} Poin
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary btn-sm" title="Detail & Catat Pelanggaran">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-secondary btn-sm" style="color: var(--accent-color); border-color: rgba(99, 102, 241, 0.2);" title="Edit Profil">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua catatan pelanggarannya juga akan terhapus.')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger-color); border-color: rgba(244, 63, 94, 0.2);" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $students->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
