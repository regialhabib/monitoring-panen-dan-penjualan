<?php

namespace App\Http\Controllers;

use App\Models\Stok;

use App\Models\Penjualan;
use App\Models\JenisJeruk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::with('jenis')->get();
        $jenisJeruks = JenisJeruk::all();
        $stoks = Stok::with('jenis')->get();

        return view('panen.riwayat_penjualan', compact('penjualans', 'jenisJeruks', 'stoks'));
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
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'jumlah_penjualan'  => 'required|numeric|min:0.01',
            'id_jenis'          => 'required|exists:jenis_jeruks,id',
            'keterangan'        => 'required|string',
            'harga'             => 'required|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Ambil stok berdasarkan jenis
            $stok = Stok::where('id_jenis', $request->id_jenis)->lockForUpdate()->first();


            if (!$stok || $stok->jumlah_stok < $request->jumlah_penjualan) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Stok tidak mencukupi untuk penjualan ini');
            }

            // Simpan penjualan
            Penjualan::create([
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'jumlah_penjualan'  => $request->jumlah_penjualan,
                'keterangan'        => $request->keterangan,
                'id_jenis'          => $request->id_jenis,
                'harga'             => $request->harga,
                'total_harga'       => $request->total_harga,
            ]);

            // Kurangi stok
            $stok->jumlah_stok -= $request->jumlah_penjualan;
            $stok->save();

            DB::commit();

            return redirect()
                ->route('riwayat-penjualan.index')
                ->with('success', 'Data penjualan berhasil ditambahkan');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data penjualan gagal: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:penjualans,id',
            'tanggal_penjualan' => 'required|date',
            'jumlah_penjualan'  => 'required|numeric|min:0.01',
            'harga'             => 'required|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
            'id_jenis'          => 'required|exists:jenis_jeruks,id',
            'keterangan'        => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Ambil data penjualan lama
            $penjualan = Penjualan::lockForUpdate()->findOrFail($request->id);

            $jumlahLama = $penjualan->jumlah_penjualan;
            $jenisLama  = $penjualan->id_jenis;

            $jumlahBaru = $request->jumlah_penjualan;
            $jenisBaru  = $request->id_jenis;

            // 🔹 Kembalikan stok lama
            $stokLama = Stok::where('id_jenis', $jenisLama)
                ->lockForUpdate()
                ->first();

            if (!$stokLama) {
                throw new \Exception('Stok lama tidak ditemukan');
            }

            $stokLama->jumlah_stok += $jumlahLama;
            $stokLama->save();

            // 🔹 Ambil / buat stok baru
            $stokBaru = Stok::where('id_jenis', $jenisBaru)
                ->lockForUpdate()
                ->first();

            if (!$stokBaru) {
                $stokBaru = Stok::create([
                    'id_jenis'    => $jenisBaru,
                    'jumlah_stok' => 0
                ]);
            }

            // ❌ Validasi stok cukup
            if ($stokBaru->jumlah_stok < $jumlahBaru) {
                throw new \Exception('Stok tidak mencukupi untuk penjualan ini');
            }

            // 🔹 Kurangi stok baru
            $stokBaru->jumlah_stok -= $jumlahBaru;
            $stokBaru->save();

            // 🔹 Update penjualan
            $penjualan->update([
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'jumlah_penjualan'  => $jumlahBaru,
                'harga'             => $request->harga,
                'total_harga'       => $jumlahBaru * $request->harga, // hitung ulang
                'id_jenis'          => $jenisBaru,
                'keterangan'        => $request->keterangan,
            ]);

            DB::commit();

            return redirect()
                ->route('riwayat-penjualan.index')
                ->with('success', 'Data penjualan berhasil diperbarui');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Ambil penjualan
            $penjualan = Penjualan::lockForUpdate()->findOrFail($id);

            // Ambil stok sesuai jenis
            $stok = Stok::where('id_jenis', $penjualan->id_jenis)
                ->lockForUpdate()
                ->first();

            if (!$stok) {
                throw new \Exception('Stok tidak ditemukan');
            }

            // Kembalikan stok
            $stok->jumlah_stok += $penjualan->jumlah_penjualan;
            $stok->save();

            // Hapus penjualan
            $penjualan->delete();

            DB::commit();

            return redirect()
                ->route('riwayat-penjualan.index')
                ->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function report()
    {
        return view('panen.penjualan_report');
    }
}
