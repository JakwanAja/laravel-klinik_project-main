@extends('layouts.app_modern')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                        <div class="d-flex align-items-center">
                            <!-- Tambahkan ikon -->
                            <div class="me-4">
                                <img src="/modern/src/assets/images/profile/kapibara.jpg" alt="Welcome Icon" class="rounded-circle shadow" width="100" height="100">
                            </div>

                            <!-- Konten teks -->
                            <div>
                                <h2 class="text-primary fw-bold mt-3">SELAMAT DATANG</h2>
                                <p class="text-danger fs-5">Anda Login menggunakan Akun User</p>
                            </div>
                        </div>

                        <!-- Elemen tambahan untuk memisahkan -->
                        <hr class="my-4">
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
