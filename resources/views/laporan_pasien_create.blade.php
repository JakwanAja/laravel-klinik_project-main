@extends('layouts.app_modern')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DATA PASIEN</div>
                <div class="card-body">
                    <form action="/laporan-pasien" method="GET" target="_blank">
                        <div class="row mt-3">
                            <div class="form-group col-md-4">
                                <label for="tanggal_mulai">Tanggal Daftar Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_akhir">Tanggal Daftar Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">-- Semua Data --</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Cetak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
