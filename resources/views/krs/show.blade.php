@extends('layouts.app')
@section('title', 'Detail KRS')
@push('styles') @include('partials.crud-styles') @endpush

@section('content')
<h1 class="page-title">Detail KRS</h1>

<div class="card form-max">
    <div class="card-header">Informasi KRS</div>
    <div class="card-body" style="padding:0">
        <table class="detail-table">
            <tr><td>ID KRS</td><td>{{ $krs->id }}</td></tr>
            <tr><td>NPM</td><td>{{ $krs->npm }}</td></tr>
            <tr><td>Nama Mahasiswa</td><td>{{ $krs->mahasiswa->nama ?? '-' }}</td></tr>
            <tr><td>Dosen Wali</td><td>{{ $krs->mahasiswa->dosen->nama ?? '-' }}</td></tr>
            <tr><td>Kode Matakuliah</td><td>{{ $krs->kode_matakuliah }}</td></tr>
            <tr><td>Nama Matakuliah</td><td>{{ $krs->matakuliah->nama_matakuliah ?? '-' }}</td></tr>
            <tr><td>SKS</td><td>{{ $krs->matakuliah->sks ?? '-' }} SKS</td></tr>
            <tr><td>Dibuat</td><td>{{ $krs->created_at->format('d M Y, H:i') }}</td></tr>
            <tr><td>Diperbarui</td><td>{{ $krs->updated_at->format('d M Y, H:i') }}</td></tr>
        </table>
    </div>
</div>

<div class="btn-group" style="margin-top:1.5rem">
    @if(auth()->user()->isAdmin())
        <a href="{{ route('krs.edit', $krs->id) }}" class="btn btn-warning">Edit</a>
    @endif

    @if(auth()->user()->isAdmin() || $krs->npm === auth()->user()->npm)
    <form action="{{ route('krs.destroy', $krs->id) }}" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus KRS ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            {{ auth()->user()->isAdmin() ? 'Hapus' : 'Drop Mata Kuliah' }}
        </button>
    </form>
    @endif

    <a href="{{ route('krs.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
