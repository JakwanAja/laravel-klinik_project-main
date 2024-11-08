@extends('layouts.app_modern_laporan')

@section('content')
<div class="text-center">
    <h3>LAPORAN DATA PENDAFTARAN</h3>
    <p>Laporan Pendaftaran Tanggal {{request('tanggal_mulai')}} / {{request('tanggal_akhir')}} </p>
</div><table class="table table-bordered">
    <thead>
        <tr>
            <th width="1%">NO</th>
            <th>No Pasien</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Tgl Daftar</th>
            <th>Poli</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($models as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->pasien->no_pasien }}</td>
            <td>{{ $item->pasien->nama }}</td>
            <td>{{ $item->pasien->umur }}</td>
            <td>{{ $item->pasien->jenis_kelamin }}</td>
            <td>{{ $item->tanggal_daftar }}</td>
            <td>{{ $item->poli }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
