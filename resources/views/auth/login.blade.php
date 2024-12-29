@extends('layouts.master-without_nav')

@section('title') Login @endsection

@section('content')

<body class="account-body accountbg">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 100%; max-width: 400px; border-radius: 8px;">
            <div class="card-header text-center" style="background-color: #007bff; color: white; border-radius: 8px 8px 0 0;">
                <h4 class="mb-0">Masuk Akun</h4>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success text-center">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Nama Pengguna</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan Nama Pengguna" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan Password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
