<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Panen;
use App\Models\JenisJeruk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class PanenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panens = Panen::with('jenis')->get();
        $stoks = Stok::with('jenis')->get();
        $jenisJeruks = JenisJeruk::all();
        return view('panen.riwayat_panen', compact('panens', 'jenisJeruks', 'stoks'));
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
            'tanggal_panen' => 'required',
            'jumlah_panen' => 'required',
            'id_jenis' => 'required|exists:jenis_jeruks,id',
            'keterangan' => 'required',
        ]);

        DB::beginTransaction();

        try {
            Panen::create([
                'tanggal_panen' => $request->tanggal_panen,
                'jumlah_panen' => $request->jumlah_panen,
                'keterangan' => $request->keterangan,
                'id_jenis' => $request->id_jenis,
            ]);

            $jumlah_stok = Stok::where('id_jenis', $request->id_jenis)->first();
            if ($jumlah_stok) {
                $jumlah_stok->jumlah_stok += $request->jumlah_panen;
                $jumlah_stok->save();
            } else {
                Stok::create([
                    'id_jenis' => $request->id_jenis,
                    'jumlah_stok' => $request->jumlah_panen,
                ]);
            }


            DB::commit();
            return redirect()->route('riwayat-panen.index')->with('success', 'Data Panen berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('riwayat-panen.index')->with('error', 'Data Panen gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Panen $panen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panen $panen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'tanggal_panen' => 'required',
            'jumlah_panen' => 'required',
            'id_jenis' => 'required|exists:jenis_jeruks,id',
            'keterangan' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $panen = Panen::findOrFail($request->id);

            $jumlah_panen_lama = $panen->jumlah_panen;
            $jumlah_panen_baru = $request->jumlah_panen;

            // SELISIH
            $selisih = $jumlah_panen_baru - $jumlah_panen_lama;

            // SIMPAN ID JENIS LAMA
            $id_jenis_lama = $panen->id_jenis;

            // UPDATE PANEN (UPDATE id_jenis juga)
            $panen->update($request->all());

            // *** KASUS 1: Jika id_jenis TIDAK BERUBAH ***
            if ($id_jenis_lama == $request->id_jenis) {

                $stok = Stok::firstOrCreate(
                    ['id_jenis' => $panen->id_jenis],
                    ['jumlah_stok' => 0]
                );

                $stok->jumlah_stok += $selisih;
                $stok->save();
            } else {
                // *** KASUS 2: id_jenis BERUBAH ***

                // Kurangi stok jenis lama
                $stok_lama = Stok::firstOrCreate(
                    ['id_jenis' => $id_jenis_lama],
                    ['jumlah_stok' => 0]
                );

                $stok_lama->jumlah_stok -= $jumlah_panen_lama;
                $stok_lama->save();

                // Tambah stok jenis baru
                $stok_baru = Stok::firstOrCreate(
                    ['id_jenis' => $request->id_jenis],
                    ['jumlah_stok' => 0]
                );

                $stok_baru->jumlah_stok += $jumlah_panen_baru;
                $stok_baru->save();
            }

            DB::commit();
            return redirect()->route('riwayat-panen.index')->with('success', 'Data Panen berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('riwayat-panen.index')->with('error', 'Data Panen gagal diubah');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Panen::find($id)->delete();
            $jumlah_stok = Stok::select('jumlah_stok')->where('id_jenis', $id)->first();
            $jumlah_stok->jumlah_stok -= $jumlah_stok->jumlah_stok;
            $jumlah_stok->save();
            DB::commit();
            return redirect()->route('riwayat-panen.index')->with('success', 'Data Panen berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('riwayat-panen.index')->with('error', 'Data Panen gagal dihapus');
        }
    }

    public function report()
    {
        return view('panen.panen_report');
    }

    public function data(Request $request)
    {
        $request->validate([
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        $data = Panen::with('jenis')
            ->whereBetween('tanggal_panen', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ])
            ->orderBy('tanggal_panen')
            ->get();

        return response()->json($data);
    }

    public function print(Request $request)
    {
        $request->validate([
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $data = Panen::with('jenis')
            ->whereBetween('tanggal_panen', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ])
            ->orderBy('tanggal_panen')
            ->get();

        $pdf = Pdf::loadView('panen.panen_print', [
            'data' => $data,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('panen.panen_print');
    }
}
