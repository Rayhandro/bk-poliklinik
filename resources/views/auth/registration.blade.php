@extends('layouts.master-without_nav')

@section('title') Daftar @endsection

@section('content')

<body class="account-body accountbg">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 100%; max-width: 400px; border-radius: 8px;">
            <div class="card-header text-center" style="background-color: #007bff; color: white; border-radius: 8px 8px 0 0;">
                <h4 class="mb-0">Pendaftaran Akun</h4>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success text-center">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}" autofocus>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" id="no_ktp" placeholder="Masukkan No KTP" value="{{ old('no_ktp') }}">
                        @error('no_ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="Masukkan No HP" value="{{ old('no_hp') }}">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
