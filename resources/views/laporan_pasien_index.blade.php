@extends('layouts.app_modern_laporan')

@section('content')
<div class="text-center">
    <h3>LAPORAN DATA PASIEN</h3>
    <p>Laporan Pasien Tanggal {{request('tanggal_mulai')}} / {{request('tanggal_akhir')}} </p>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="1%">NO</th>
            <th>No Pasien</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Tgl Buat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($models as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->no_pasien }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->umur }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
