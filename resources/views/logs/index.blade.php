@extends('layouts.app')

@section('title', 'Laporan Pelanggaran Siswa')
@section('page_title', 'Laporan Pelanggaran Siswa')
@section('page_subtitle', 'Daftar seluruh laporan pelanggaran siswa yang tercatat di sistem.')

@section('content')
    <!-- Filter and Search Bar -->
    <div class="filter-bar">
        <form action="{{ route('logs.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa / Kelas..." class="form-control" style="width: 250px;">
            </div>
            
            <div class="filter-group">
                <select name="category" class="form-control" style="width: 180px;">
                    <option value="">Semua Kategori</option>
                    <option value="Ringan" {{ request('category') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="Sedang" {{ request('category') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Berat" {{ request('category') == 'Berat' ? 'selected' : '' }}>Berat</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'category']))
                <a href="{{ route('logs.index') }}" class="btn btn-secondary" style="color: var(--text-muted);">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('logs.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Catat Pelanggaran Baru
        </a>
    </div>

    <!-- Logs Table -->
    <div class="section-card">
        @if($logs->isEmpty())
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <i class="fa-regular fa-clipboard" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>Tidak ada laporan pelanggaran ditemukan.</p>
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
                            <th>Poin Sanksi</th>
                            <th>Tanggal Laporan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    <a href="{{ route('students.show', $log->student->id) }}" style="font-weight: 600; text-decoration: underline; text-underline-offset: 3px;">
                                        {{ $log->student->name }}
                                    </a>
                                </td>
                                <td>{{ $log->student->class }}</td>
                                <td>
                                    <div style="font-weight: 500;">{{ $log->violation->name }}</div>
                                    @if($log->description)
                                        <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.2rem;">
                                            "{{ $log->description }}"
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower($log->violation->category) }}">
                                        {{ $log->violation->category }}
                                    </span>
                                </td>
                                <td>
                                    <span class="points-tag points-danger">
                                        {{ $log->points }}
                                    </span>
                                </td>
                                <td>
                                    {{ $log->reported_at->format('d M Y') }}
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pelanggaran ini? Poin siswa akan dikurangi kembali.')" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger-color); border-color: rgba(244, 63, 94, 0.2); background: rgba(244, 63, 94, 0.02);">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $logs->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
