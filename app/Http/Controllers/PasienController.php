<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;


class PasienController extends Controller
{
    use SoftDeletes;

    public function makeAdmin()
    {
        // Cari user dengan ID xx
        $users = User::find([33, 47]);
        
        $role = Role::firstOrCreate(['name' => 'admin']);
        
        foreach ($users as $user) {
            $user->assignRole($role);
        }
    
        return "Sekarang anda adalah Admin.";
    }
    
    public function index()
    {
        //Api restFull
        $pasien = \App\Models\Pasien::latest()->paginate(10);
        if (request()->wantsJson()) {
            return response()->json($pasien);
        }
        $data['pasien'] = $pasien;
        return view('pasien_index' , $data);
        // End Api restFull

        if (request()->filled('p')) {
            // Pencarian berdasarkan input dari request (parameter 'p')
            $data['pasien'] = \App\Models\Pasien::search(request('p'))->paginate(10);
        } else {
            $data['pasien'] = \App\Models\Pasien::latest()->paginate(10);
        }
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

        if ($request->wantsJson()) { 
            return response()->json($pasien); 
        }

        flash('Data sudah disimpan')->success(); 
        return back(); 
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
            'alamat' => 'nullable', 
        ]);
    
        // Temukan pasien berdasarkan ID atau gagal jika tidak ditemukan
        $pasien = \App\Models\Pasien::findOrFail($id);
    
        // Ambil data input kecuali foto
        $requestData = $request->except('foto');
        $pasien->fill($requestData);
    
        // Jika ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pasien->foto) {
                Storage::delete($pasien->foto);
            }
    
            // Simpan foto baru dan update kolom foto di database
            $fotoPath = $request->file('foto')->store('images', 'public');
            $pasien->foto = $fotoPath;
        }
        $pasien->save();
    
        // Kembalikan respons JSON jika diminta
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pasien,
                'message' => 'Data pasien berhasil diperbarui!'
            ], 200);
        }
    
        // Jika bukan JSON, kembalikan redirect dengan flash message
        flash('Data pasien berhasil diperbarui!')->success();
        return redirect('/pasien');
    }

    public function __construct()
    {
        $this->middleware('role:admin')->only('destroy');
    }

    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
    
        // Cek jika pasien memiliki data pendaftaran
        if ($pasien->daftar()->exists()) { // Menggunakan exists() untuk efisiensi query
            return response()->json([
                'success' => false,
                'message' => 'Data tidak bisa dihapus karena sudah ada data pendaftaran'
            ], 400); 
        }
    
        // Hapus file foto jika ada
        if ($pasien->foto && Storage::exists($pasien->foto)) {
            Storage::delete($pasien->foto);
        }
        $pasien->delete();
        flash('Data sudah dihapus')->success();
    
        //return response()->json([
           // 'success' => true,
           // 'message' => 'Data pasien berhasil dihapus!'
       // ], 200);

       return back();
    }
    
    public function restore($id)
    {
        // Ambil pasien meskipun sudah di-soft delete
        $pasien = Pasien::withTrashed()->find($id);

        // Jika data tidak ditemukan
        if (!$pasien) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Restore data pasien yang telah di-soft delete
        $pasien->restore();

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil dipulihkan!',
            'data' => $pasien
        ], 200);
    }
}
