@extends('layouts.app_modern')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
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
                                <img src="https://cdn-icons-png.flaticon.com/512/9203/9203764.png" alt="Welcome Icon" class="rounded-circle shadow" width="100" height="100">
                            </div>

                            <!-- Konten teks -->
                            <div>
                                <h2 class="text-primary fw-bold mt-3">SELAMAT DATANG</h2>
                                <p class="text-secondary fs-5">Anda Login Menggunakan Akun Admin</p>
                                <p class="text-muted">Ini adalah Halaman Dashboard yang digunakan untuk mengelola semua Data.</p>
                                <p class="text-muted">Silahkan dikelola dengan baik ☺️</p>
                            </div>
                        </div>

                        <!-- Elemen tambahan untuk memisahkan -->
                        <hr class="my-4">

                        <!-- Seksi informasi tambahan -->
                        <div class="p-4 bg-light rounded shadow-sm">
                            <h5 class="text-primary mb-3">Panduan Awal</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Mengelola data pasien secara efisien.</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Membuat dan mengelola data pendaftaran.</span>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>Membuat laporan dengan cepat.</span>
                                </li>
                            </ul>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4 py-2">
                                Learn More
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
