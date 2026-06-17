@extends('layouts.app')

@section('title', 'Katalog Jenis Pelanggaran')
@section('page_title', 'Katalog Jenis Pelanggaran')
@section('page_subtitle', 'Kelola daftar pelanggaran tata tertib beserta pembobotan poin sanksi.')

@section('content')
    <!-- Filter and Search Bar -->
    <div class="filter-bar">
        <form action="{{ route('violations.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis pelanggaran..." class="form-control" style="width: 250px;">
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
                <a href="{{ route('violations.index') }}" class="btn btn-secondary" style="color: var(--text-muted);">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('violations.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Pelanggaran Baru
        </a>
    </div>

    <!-- Violations Table -->
    <div class="section-card">
        @if($violations->isEmpty())
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>Tidak ada data jenis pelanggaran ditemukan.</p>
            </div>
        @else
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Deskripsi Pelanggaran</th>
                            <th style="width: 150px;">Kategori</th>
                            <th style="width: 120px;">Bobot Poin</th>
                            <th style="text-align: right; width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($violations as $violation)
                            <tr>
                                <td style="font-family: monospace; color: var(--text-secondary);">
                                    #{{ str_pad($violation->id, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td style="font-weight: 500;">
                                    {{ $violation->name }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower($violation->category) }}">
                                        {{ $violation->category }}
                                    </span>
                                </td>
                                <td>
                                    <span class="points-tag points-danger" style="font-size: 0.95rem; font-weight: 700;">
                                        +{{ $violation->points }} Poin
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('violations.edit', $violation->id) }}" class="btn btn-secondary btn-sm" style="color: var(--accent-color); border-color: rgba(99, 102, 241, 0.2);" title="Edit Pelanggaran">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <form action="{{ route('violations.destroy', $violation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis pelanggaran ini?')" style="display: inline;">
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
                {{ $violations->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
