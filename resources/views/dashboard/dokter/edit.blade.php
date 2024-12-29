@extends('layouts.master')

@section('title', 'Edit Profil Dokter')

@section('content')
<div class="container">
    <h3>Edit Profil</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('backoffice.dokter.updateProfil') }}" method="POST">
        @csrf
        @method('PUT') <!-- Menggunakan metode PUT -->
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $dokter->name) }}">
        </div>
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $dokter->phone) }}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $dokter->dokter->alamat ?? '') }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
