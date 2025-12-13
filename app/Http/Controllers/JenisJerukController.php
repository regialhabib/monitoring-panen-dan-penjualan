<?php

namespace App\Http\Controllers;

use App\Models\JenisJeruk;
use Illuminate\Http\Request;


class JenisJerukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisJeruks = JenisJeruk::all();
        return view('panen.jenis_jeruk', compact('jenisJeruks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'jenis_jeruk' => 'required|string|max:255',
        ]);

        try {
            JenisJeruk::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan jenis jeruk baru.');
        }

        return redirect()->route('jenis-jeruk.index')
            ->with('success', 'Jenis Jeruk baru berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(JenisJeruk $jenisJeruk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisJeruk $jenisJeruk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $jenisJeruk = JenisJeruk::findOrFail($request->id);
            $jenisJeruk->update($request->all());
        } catch (\Exception $e) {
            return redirect()->route('jenis-jeruk.index')
                ->with('error', 'Jenis Jeruk tidak ditemukan.');
        }
        
        return redirect()->route('jenis-jeruk.index')
            ->with('success', 'Jenis Jeruk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $jenisJeruk = JenisJeruk::findOrFail($id);
            $jenisJeruk->delete();
        } catch (\Exception $e) {
            return redirect()->route('jenis-jeruk.index')
                ->with('error', 'Jenis Jeruk tidak ditemukan.');
        }
        
        return redirect()->route('jenis-jeruk.index')
            ->with('success', 'Jenis Jeruk berhasil dihapus.');
    }
}
