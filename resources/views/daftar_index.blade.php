@extends('layouts.app_modern', ['title' => 'Data Pendaftaran'])
@section('content')
    <div class="card">
        <div class="card-header">Form Pendaftaran</div>
        <div class="card-body">
            <h3>Data Pendaftaran</h3>

            <form action="">
                <div class="row g-3 mb-2">
                    <div class="col">
                        <Input type="text" name="psn" class="form-control" placeholder="Nama atau Nomor Pasien"
                            value="{{request('psn')}}"></Input>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">CARI</button>
                    </div>
                </div>
            </form> 

            <div class="row mb-3 mt-3">
                <div class="col-md-12">
                    <a href="/daftar/create" class="btn btn-primary btn-sm mt-3">Tambah Data</a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>JENIS KELAMIN</th>
                        <th>TANGGAL DAFTAR</th>
                        <th>POLI</th>
                        <th>KELUHAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <TBody>
                    @foreach ($daftar as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->pasien->nama}}</td>
                            <td>{{$item->pasien->jenis_kelamin}}</td>
                            <td>{{$item->tanggal_daftar}}</td>
                            <td>{{$item->poli }}</td>
                            <td>{{$item->keluhan}}</td>
                            <td>
                                <a href="/daftar/ {{ $item->id }}" class="btn btn-info btn-sm " >Detail</a>
                                <form action="/daftar/ {{$item->id}}" method="post" class="d-inline"></form>
                                <a href="/daftar/{{$item->id}}/edit" class="btn btn-warning btn-sm ml-2">
                                    Edit
                                </a>
                                <form action="/daftar/{{ $item->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method ('delete')
                                    <button class="btn btn-danger btn-sm ml-2" 
                                        onclick="return confirm('Yakin nih mau hapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </TBody>
            </table>
            {!! $daftar->links() !!}
        </div>
    </div>

@endsection