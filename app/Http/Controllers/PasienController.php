<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->filled('p')) {
            // Pencarian berdasarkan input dari request (parameter 'p')
            $data['pasien'] = \App\Models\Pasien::search(request('p'))->paginate(10);
        } else {
            $data['pasien'] = \App\Models\Pasien::latest()->paginate(10);
        }

        // Kembalikan view dengan data pasien
        return view('pasien_index', $data);
    }

    public function create()
    {
        return view(view: 'pasien_create');
    }

    
    public function store(Request $request)
    {
        $requestData= $request->validate([
            'no_pasien' => 'required|unique:pasiens,no_pasien',
            'nama' => 'required|min:3',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'nullable', //alamat tidak boleh kosong
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5000'
        ]);

        $pasien = new \App\Models\Pasien();
        $pasien->fill($requestData);
        $path = $request->file('foto')->store('images', 'public');
        $pasien->foto = $path; // Simpan path relatif ke database    
        $pasien->save();

        flash('Data sudah disimpan')->success(); 
        return back(); // kembali ke halaman sebelumnya
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['pasien'] = \App\Models\Pasien::findOrFail($id);
        return view('pasien_show', $data);
    }


    public function edit(string $id)
    {
        $data['pasien'] = \App\Models\Pasien::findOrFail($id);
        return view('pasien_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'no_pasien' => 'required|unique:pasiens,no_pasien,' . $id, // Unique dengan pengecualian ID pasien yang diedit
            'nama' => 'required|min:3',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'alamat' => 'nullable', // alamat boleh kosong
        ]);
    
        // Mengambil pasien berdasarkan ID
        $pasien = \App\Models\Pasien::findOrFail($id);
    
        // Mendefinisikan dan mengisi requestData, mengambil semua input kecuali foto
        $requestData = $request->except('foto');
        
        // Mengisi data pasien dengan requestData
        $pasien->fill($requestData);
    
        // Jika ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            Storage::delete($pasien->foto);
            // Simpan foto baru dan perbarui kolom foto di database
            $pasien->foto = $request->file('foto')->store('public');
        }
    
        // Simpan perubahan pada model pasien
        $pasien->save();
        flash('Data sudah diupdate')->success();
        return redirect('/pasien');
    }

    public function destroy(string $id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        if ($pasien->daftar->count() > 0) {
            flash('Data tidak bisa dihapus karena sudah ada data pendaftaran')->error();
            return back();
        }
        if ($pasien->foto != null && Storage::exists($pasien->foto)) {
            Storage::delete($pasien->foto);
        }
        $pasien->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }
}
