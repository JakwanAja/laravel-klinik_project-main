@extends('layouts.app_modern', ['title' => 'Detail Pendaftaran Pasien'])

@section('content')
@if(auth()->user()->hasRole('admin'))
    <!-- Konten yang hanya bisa dilihat oleh admin -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">DETAIL PASIEN {{ strtoupper($pasien->nama) }}</div>
                    <div class="card-body">
                        <h4>Data Pasien</h4>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <th width="15%">No Pasien</th>
                                    <td> : {{ $pasien->no_pasien }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pasien</th>
                                    <td> : {{ $pasien->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td> : {{ $pasien->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Umur</th>
                                    <td> : {{ $pasien->umur }} Tahun</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td> : {{ $pasien->alamat ?? 'Tidak ada alamat' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <!-- Tombol untuk mengedit atau kembali -->
                        <div class="mt-4">
                            <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-warning">Edit Pasien</a>
                            <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Kembali ke Daftar Pasien</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Konten untuk pengguna selain admin -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p>Anda tidak memiliki akses ke halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
