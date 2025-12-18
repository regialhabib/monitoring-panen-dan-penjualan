<?php

namespace App\Http\Controllers;

use App\Models\JenisJeruk;
use App\Models\RencanaPanen;
use Illuminate\Http\Request;
use App\Models\RencananPanen;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRencananPanenRequest;
use App\Http\Requests\UpdateRencananPanenRequest;

class RencanaPanenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisJeruks = JenisJeruk::orderBy('jenis_jeruk')->get();
        return view('panen.kalender', compact('jenisJeruks'));
    }


    public function events(Request $request)
    {
        $rencanaPanens = RencanaPanen::with('jenis')->get();

        $events = $rencanaPanens->map(function ($item) {

            // warna berdasarkan status
            $color = match ($item->status) {
                'harvested' => '#1cc88a', // success
                'cancelled' => '#e74a3b', // danger
                default     => '#4e73df', // primary (planned)
            };

            return [
                'id'    => $item->id,
                'title' => $item->jenis->jenis_jeruk
                    . ' - '
                    . $item->jumlah_rencana_formatted
                    . ' kg',
                'start' => $item->tanggal_rencana->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor'     => $color,

                // extra data (dipakai saat klik event)
                'extendedProps' => [
                    'id_jenis' => $item->id_jenis,
                    'jumlah'   => $item->jumlah_rencana,
                    'catatan'  => $item->catatan,
                    'status'   => $item->status,
                ]
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_rencana' => 'required|date',
            'id_jenis'        => 'required|exists:jenis_jeruks,id',
            'jumlah_rencana'  => 'required|numeric|min:0',
            'catatan'         => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $rencana = RencanaPanen::create([
                'tanggal_rencana' => $request->tanggal_rencana,
                'id_jenis'        => $request->id_jenis,
                'jumlah_rencana'  => $request->jumlah_rencana,
                'catatan'         => $request->catatan,
                'status'          => 'planned',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rencana panen berhasil disimpan',
                'data'    => $rencana->load('jenis'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rencana = RencanaPanen::findOrFail($id);

        return response()->json([
            'id' => $rencana->id,
            'tanggal_rencana' => $rencana->tanggal_rencana->format('Y-m-d'),
            'id_jenis' => $rencana->id_jenis,
            'jumlah_rencana' => format($rencana->jumlah_rencana),
            'catatan' => $rencana->catatan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rencana_panens,id',
            'tanggal_rencana' => 'required|date',
            'id_jenis' => 'required|exists:jenis_jeruks,id',
            'jumlah_rencana' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $rencana = RencanaPanen::findOrFail($request->id);

            $rencana->update([
                'tanggal_rencana' => $request->tanggal_rencana,
                'id_jenis'        => $request->id_jenis,
                'jumlah_rencana'  => $request->jumlah_rencana,
                'catatan'         => $request->catatan,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Rencana panen berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rencana = RencanaPanen::findOrFail($id);
            $rencana->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rencana panen berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus rencana panen'
            ], 500);
        }
    }
}
