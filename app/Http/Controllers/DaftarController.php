<?php

namespace App\Http\Controllers;

use App\Models\Daftar;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\UpdateDaftarRequest;
use Illuminate\Http\Request;

class DaftarController extends Controller
{

    public function __construct()
    {
        // Middleware hanya untuk role admin
        $this->middleware('role:admin');
    }

    public function index()
    {
        if (request()->filled('psn')) {
            $data['daftar'] = \App\Models\Daftar::search(request('psn'))->paginate(10);
        } else {
            $data['daftar'] = \App\Models\Daftar::latest()->paginate(10);
        }

        return view('daftar_index', $data);
        //$daftar = \App\Models\Daftar::with('pasien')->latest()->paginate(20);
        //return view('daftar_index', compact('daftar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['listPasien'] = \App\Models\Pasien::orderBy('nama', 'asc')->get();
        $data['listPoli'] = [
            'Poli Umum' => 'Poli Umum',
            'Poli Gigi' => 'Poli Gigi',
            'Poli Kandungan' => 'Poli Kandungan',
            'Poli Anak' => 'Poli Anak',
        ];
        return view('daftar_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'tanggal_daftar'=> 'required',
            'pasien_id'=> 'required',
            'poli' => 'required',
            'keluhan' => 'required',
        ]);

        $daftar =new Daftar();
        $daftar->fill($requestData);
        $daftar->status_daftar = 'baru'; // nilai default untuk status_daftar
        $daftar->save();
        flash('Data berhasil disimpan')->success();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['daftar'] = \App\Models\Daftar::findOrFail($id);
        return view('daftar_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daftar $daftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'tindakan' => 'required',
            'diagnosis' => 'required',
        ]);

        $daftar = \App\Models\Daftar::findOrFail($id);
        $daftar ->fill($requestData);
        $daftar->save();
        flash('Data berhasil disimpan')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daftar $daftar)
    {
        $daftar->delete();
        flash('Data berhasil dihapus')->success();
        return back();
    }
}
