<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {




        /**
         * =========================
         * KPI
         * =========================
         */

        $totalPanen = DB::table('panens')->sum('jumlah_panen');
        $totalPenjualan = DB::table('penjualans')->sum('jumlah_penjualan');
        $stokSaatIni = DB::table('stoks')->sum('jumlah_stok');
        $pendapatan = DB::table('penjualans')->sum('total_harga');

        $kpi = [
            'total_panen'     => $totalPanen,
            'total_penjualan' => $totalPenjualan,
            'stok_saat_ini'   => $stokSaatIni,
            'pendapatan'      => $pendapatan,
        ];

        /**
         * =========================
         * CHART PANEN & PENJUALAN PER BULAN
         * =========================
         */

        $panenBulanan = DB::table('panens')
            ->select(
                DB::raw('MONTH(tanggal_panen) as bulan'),
                DB::raw('SUM(jumlah_panen) as total')
            )
            ->groupBy(DB::raw('MONTH(tanggal_panen)'))
            ->pluck('total', 'bulan');

        $penjualanBulanan = DB::table('penjualans')
            ->select(
                DB::raw('MONTH(tanggal_penjualan) as bulan'),
                DB::raw('SUM(jumlah_penjualan) as total')
            )
            ->groupBy(DB::raw('MONTH(tanggal_penjualan)'))
            ->pluck('total', 'bulan');

        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $panenPerBulan = [];
        $penjualanPerBulan = [];

        for ($i = 1; $i <= 12; $i++) {
            $panenPerBulan[] = $panenBulanan[$i] ?? 0;
            $penjualanPerBulan[] = $penjualanBulanan[$i] ?? 0;
        }

        /**
         * =========================
         * STOK PER JENIS
         * =========================
         */

        $stokPerJenis = DB::table('stoks')
            ->join('jenis_jeruks', 'stoks.id_jenis', '=', 'jenis_jeruks.id')
            ->select(
                'jenis_jeruks.jenis_jeruk',
                DB::raw('SUM(stoks.jumlah_stok) as total')
            )
            ->groupBy('jenis_jeruks.jenis_jeruk')
            ->get();

        /**
         * =========================
         * PENDAPATAN PER BULAN
         * =========================
         */

        $pendapatanBulanan = DB::table('penjualans')
            ->select(
                DB::raw('MONTH(tanggal_penjualan) as bulan'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy(DB::raw('MONTH(tanggal_penjualan)'))
            ->pluck('total', 'bulan');

        $pendapatanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanPerBulan[] = $pendapatanBulanan[$i] ?? 0;
        }

        /**
         * =========================
         * KONTRIBUSI PENJUALAN PER JENIS (PIE)
         * =========================
         */

        $kontribusiPenjualan = DB::table('penjualans')
            ->join('jenis_jeruks', 'penjualans.id_jenis', '=', 'jenis_jeruks.id')
            ->select(
                'jenis_jeruks.jenis_jeruk',
                DB::raw('SUM(penjualans.total_harga) as total')
            )
            ->groupBy('jenis_jeruks.jenis_jeruk')
            ->get();

        return view('home', compact(
            'kpi',
            'bulan',
            'panenPerBulan',
            'penjualanPerBulan',
            'stokPerJenis',
            'pendapatanPerBulan',
            'kontribusiPenjualan'
        ));
    }
}
