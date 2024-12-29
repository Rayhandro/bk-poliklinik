<?php

namespace App\Http\Controllers;

use App\Http\Requests\DokterRequest;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.dokter.index');
    }

    /**
     * It returns a json object of all the dokters in the database.
     *
     * @return A JSON object containing all the dokters.
     */
    public function data()
    {
        $dokters = Dokter::with('poli')->orderBy('created_at', 'desc')->get();

        return datatables($dokters)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DokterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DokterRequest $request)
    {
        $data = Dokter::create($request->validated());

        $payload = $request->validated();
        User::create([
            'name' => $payload['nama'],
            'email' => $payload['nama'],
            'password' => bcrypt($payload['alamat']),
            'id_dokter' => $data->id,
            'role' => 'dokter'
        ]);

        return response()->json([
            'message' => 'Dokter created successfully'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DokterRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DokterRequest $request, $id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->update($request->validated());

        $user = User::where('id_dokter', $id)->first();
        $user->update([
            'name' => $request->nama,
            'email' => $request->nama,
            'password' => bcrypt($request->alamat)
        ]);

        return response()->json([
            'message' => 'Dokter updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        $user = User::where('id_dokter', $id)->first();
        if ($user) $user->delete();

        return response()->json([
            'message' => 'Dokter deleted successfully'
        ], 200);
    }

    public function edit()
    {
        $dokter = auth()->user(); // Ambil data dokter login
        return view('dashboard.dokter.edit', compact('dokter'));
    }

    public function updateProfil(Request $request)
{
    // Validasi input tanpa required untuk mendukung update parsial
    $request->validate([
        'name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:15', // Nomor telepon opsional, dibatasi maksimal 15 karakter
        'alamat' => 'nullable|string|max:255' // Alamat opsional untuk digunakan sebagai password jika ada
    ]);

    // Ambil data user yang sedang login
    $dokter = auth()->user(); // Ambil dokter terkait pengguna login

    // Update data dokter jika ada input yang diberikan
    if ($request->has('name')) {
        $dokter->dokter->update(['nama' => $request->name]); // Sinkronisasi nama dengan data dokter
    }

    if ($request->has('alamat')) {
        $dokter->dokter->update(['alamat' => $request->alamat]); // Update alamat di data dokter
    }

    // Update atribut user berdasarkan input yang diberikan
    $updateData = $request->only('name', 'phone');

    if ($request->has('alamat')) {
        $updateData['password'] = bcrypt($request->alamat); // Gunakan alamat sebagai password jika ada
    }

    // Perbarui data user di database jika ada perubahan
    if (!empty($updateData)) {
        $dokter->update($updateData);
    }

    // Redirect kembali dengan pesan sukses
    return redirect()->route('backoffice.dokter.edit')->with('success', 'Profil berhasil diperbarui.');
}

}    
