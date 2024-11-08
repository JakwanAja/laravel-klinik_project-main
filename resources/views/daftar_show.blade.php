@extends('layouts.app_modern', ['title' => 'Detail Pendaftaran Pasien'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DATA PENDAFTARAN {{ strtoupper($daftar->pasien->nama) }}</div>
                <div class="card-body">
                    <h4>Data Pasien</h4>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <th width="15%">No Pasien</th>
                                <td> : {{ $daftar->pasien->no_pasien }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pasien</th>
                                <td> : {{ $daftar->pasien->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td> : {{ $daftar->pasien->jenis_kelamin }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h4>Riwayat Pasien</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Tanggal Daftar</th>
                                <th>Keluhan</th>
                                <th>Diagnosis</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar->pasien->daftar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_daftar }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{{ $item->diagnosis }}</td>
                                    <td>{{ $item->tindakan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h4>Data Pendaftaran</h4>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <th width="15%">No Pendaftaran</th>
                                <td> : {{ $daftar->id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td> : {{ $daftar->tanggal_daftar }}</td>
                            </tr>
                            <tr>
                                <th>Poli</th>
                                <td> : {{ $daftar->poli }}</td>
                            </tr>
                            <tr>
                                <th>Keluhan</th>
                                <td> : {{ $daftar->keluhan }}</td>
                            </tr>
                            <tr>
                                <th>Status Pendaftaran</th>
                                <td> : {{ $daftar->status_daftar }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h4>Hasil Diagnosis</h4>
                    <form action="/daftar/{{ $daftar->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="diagnosis">Diagnosis</label>
                            <textarea name="diagnosis" class="form-control" rows="3">{{ $daftar->diagnosis }}</textarea>
                            <span class="text-danger">{{ $errors->first('diagnosis') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="tindakan">Tindakan</label>
                            <textarea name="tindakan" class="form-control" rows="3">{{ $daftar->tindakan }}</textarea>
                            <span class="text-danger">{{ $errors->first('tindakan') }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
