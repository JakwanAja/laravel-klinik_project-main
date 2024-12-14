<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polis = Poli::all();
        return response()->json($polis);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'biaya' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $poli = Poli::create($validatedData);

        return response()->json($poli, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($poli);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'biaya' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $poli->update($validatedData);

        return response()->json($poli);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            return response()->json(['message' => 'Poli not found'], Response::HTTP_NOT_FOUND);
        }

        $poli->delete();

        return response()->json(['message' => 'Poli deleted successfully'], Response::HTTP_OK);
    }
}
