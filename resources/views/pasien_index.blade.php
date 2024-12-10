@extends('layouts.app_modern', ['title' => 'Data Pasien'])
@section('content')
    <div class="card">
        <div class="card-header">Form Pasien</div>
        <div class="card-body">
            <h3>Data pasien</h3>

            <form action="">
                <div class="row g-3 mb-2">
                    <div class="col">
                        <Input type="text" name="p" class="form-control" placeholder=" Ketikan Nama"
                            value="{{request('p')}}"></Input>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">CARI</button>
                    </div>
                </div>
            </form> 
            
            <div class="row mb-3 mt-3">
                <div class="col-md-6">
                    <a href="/pasien/create" class="btn btn-primary btn-sm">Tambah Pasien</a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pasien</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Buat</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <TBody>
                    @foreach ($pasien as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->no_pasien }}</td>
                            <td>
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" width="50" />
                                @endif
                                    {{ $item->nama }}
                            </td>
                            <td>{{ $item->umur }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="/pasien/{{ $item->id }}/edit" class="btn btn-warning btn-sm ml-2">
                                    Edit
                                </a>
                                <a href="/pasien/{{ $item->id }}" class="btn btn-info btn-sm ml-2">
                                    Detail
                                </a>
                                <form action="/pasien/{{ $item->id }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm ml-2" onclick="return confirm('Yakin nih mau hapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </TBody>
            </table>
            {!! $pasien->links() !!}
        </div>
    </div>

@endsection
