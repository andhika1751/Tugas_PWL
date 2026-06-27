@extends('layouts.app')
@section('title', 'Data KRS')
@push('styles') @include('partials.crud-styles') @endpush

@section('content')
<h1 class="page-title">Halaman KRS</h1>

<div class="mb-4" style="display:flex; gap:0.6rem; flex-wrap:wrap;">
    <a href="{{ route('krs.create') }}" class="btn btn-primary">
        {{ auth()->user()->isAdmin() ? 'Tambah Data KRS' : 'Ambil Mata Kuliah' }}
    </a>
    <a href="{{ route('krs.export.pdf') }}" class="btn btn-danger">Export PDF</a>
    <a href="{{ route('krs.export.excel') }}" class="btn btn-success">Export Excel</a>
</div>

<form method="GET" action="{{ route('krs.index') }}" class="mb-3">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari KRS..."
           style="padding:8px;width:250px;">

    <button type="submit" class="btn btn-primary">
        Cari
    </button>
</form>

<div class="card">
    <div class="card-header">Daftar KRS</div>
    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Kode MK</th>
                <th>Nama Matakuliah</th>
                <th style="width:55px">SKS</th>
                <th style="width:190px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($krsList as $i => $krs)
            <tr>
                <td>{{ $krsList->firstItem() + $i }}</td>
                <td>{{ $krs->npm }}</td>
                <td>{{ $krs->mahasiswa->nama ?? '-' }}</td>
                <td>{{ $krs->kode_matakuliah }}</td>
                <td>{{ $krs->matakuliah->nama_matakuliah ?? '-' }}</td>
                <td>{{ $krs->matakuliah->sks ?? '-' }}</td>
                <td>
                    <div class="aksi-cell">
                        <a href="{{ route('krs.show', $krs->id) }}" class="btn btn-info">Detail</a>

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('krs.edit', $krs->id) }}" class="btn btn-warning">Edit</a>
                        @endif

                        @if(auth()->user()->isAdmin() || $krs->npm === auth()->user()->npm)
                        <form action="{{ route('krs.destroy', $krs->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus KRS ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                {{ auth()->user()->isAdmin() ? 'Hapus' : 'Drop' }}
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#999;padding:2rem;">Belum ada data KRS.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:20px">
    {{ $krsList->links() }}
</div>
@endsection
