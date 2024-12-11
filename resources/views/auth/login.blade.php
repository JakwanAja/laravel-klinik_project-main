
@extends('layouts.app')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <img src="{{ asset('/modern/src/assets/images/logos/logo-2.png') }}" width="180" alt="logo">
              </a>
              <p class="text-center">Masuk sebagai admin</p>
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Username</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="current-password">
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-dark" for="remember">
                      Remember Me
                    </label>
                  </div>
                  @if (Route::has('password.request'))
                    <a class="text-primary fw-bold" href="{{ route('password.request') }}">Forgot Password?</a>
                  @endif
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 mb-4 rounded-2">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-6 mb-0 fw">Belum punya akun?</p>
                  <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Create an account</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
