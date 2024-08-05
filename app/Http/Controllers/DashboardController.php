<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Temuan;
use App\Models\Statustgr;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = Auth::user(); // get authenticated user
        $year = $request->input('year', Carbon::now()->year); // default to current year

        $temuan = Temuan::selectRaw('MONTH(tgl_lhp) as month, COUNT(*) as count')
            ->whereYear('tgl_lhp', $year)
            ->groupBy('month')
            ->get();

        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $temuan->firstWhere('month', $i);
            $months[] = Carbon::create()->month($i)->format('F');
            $counts[] = $monthData ? $monthData->count : 0;
        }

        $availableYears = Temuan::selectRaw('YEAR(tgl_lhp) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $temuans = Temuan::with(['informasi', 'opd', 'status', 'statustgr', 'pegawai', 'penyedia'])
            ->whereYear('created_at', $year)
            ->get();

        // jumlah temuan
        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua temuan per tahun
            $jumlahTemuanTahun = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('YEAR(tgl_lhp)'))
                ->pluck('total', 'year');
        } else {
            // OPD Admin hanya melihat temuan berdasarkan opd_id mereka per tahun
            $jumlahTemuanTahun = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('count(*) as total'))
                ->where('opd_id', $user->opd_id)
                ->groupBy(DB::raw('YEAR(tgl_lhp)'))
                ->pluck('total', 'year');
        }


        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua temuan
            $jumlahTemuan = Temuan::count();
        } else {
            // OPD Admin hanya melihat temuan berdasarkan opd_id mereka
            $jumlahTemuan = Temuan::where('opd_id', $user->opd_id)->count();
        }


        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua temuan berdasarkan status
            $jumlahTemuanStatus = Temuan::join('statuses', 'temuans.status_id', '=', 'statuses.id')
                ->select('statuses.status as status', DB::raw('count(*) as total'))
                ->groupBy('statuses.status')
                ->pluck('total', 'status');
        } else {
            // OPD Admin hanya melihat temuan berdasarkan opd_id mereka dan status
            $jumlahTemuanStatus = Temuan::join('statuses', 'temuans.status_id', '=', 'statuses.id')
                ->select('statuses.status as status', DB::raw('count(*) as total'))
                ->where('temuans.opd_id', $user->opd_id)
                ->groupBy('statuses.status')
                ->pluck('total', 'status');
        }

        // Calculate the total payment and remaining amount
        // if ($user->hasRole('Super Admin')) {
        //     // Super Admin melihat semua pembayaran
        //     $dibayar = DB::table('pembayarans')
        //         ->join('temuans', 'pembayarans.temuan_id', '=', 'temuans.id')
        //         ->where('pembayarans.status', 'diterima')
        //         ->where('temuans.status_id', function ($query) {
        //             $query->select('id')
        //                   ->from('statuses')
        //                   ->where('status', 'selesai')
        //                   ->limit(1);
        //         })
        //         ->sum('pembayarans.jumlah_pembayaran');
        // } else {
        //     // OPD Admin hanya melihat pembayaran berdasarkan opd_id mereka
        //     $dibayar = DB::table('pembayarans')
        //         ->join('temuans', 'pembayarans.temuan_id', '=', 'temuans.id')
        //         ->where('pembayarans.status', 'diterima')
        //         ->where('temuans.status_id', function ($query) {
        //             $query->select('id')
        //                   ->from('statuses')
        //                   ->where('status', 'selesai')
        //                   ->limit(1);
        //         })
        //         ->where('temuans.opd_id', $user->opd_id)
        //         ->sum('pembayarans.jumlah_pembayaran');
        // }


        // $jumlahDibayar = $dibayar;
        // $sisaBayar = $jumlahRekomendasi - $jumlahDibayar;

        // $jumlahRekomendasi = Temuan::sum('nilai_rekomendasi');


        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua nilai rekomendasi
            $jumlahRekomendasi = Temuan::sum('nilai_rekomendasi');
        } else {
            // OPD Admin hanya melihat nilai rekomendasi berdasarkan opd_id mereka
            $jumlahRekomendasi = Temuan::where('opd_id', $user->opd_id)->sum('nilai_rekomendasi');
        }

        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua nilai rekomendasi
            $nilaidibayar = Temuan::sum('nilai_rekomendasi') - Temuan::sum('sisa_nilai_uang');
            $sisaBayar = Temuan::sum('sisa_nilai_uang');
        } else {
            // OPD Admin hanya melihat nilai rekomendasi berdasarkan opd_id mereka
            // $jumlahRekomendasi = Temuan::where('opd_id', $user->opd_id)->sum('nilai_rekomendasi');
            $sisaBayar = Temuan::where('opd_id', $user->opd_id)->sum('sisa_nilai_uang');
            $nilaidibayar = Temuan::where('opd_id', $user->opd_id)->sum('nilai_rekomendasi') - Temuan::where('opd_id', $user->opd_id)->sum('sisa_nilai_uang');
        }
        // Get the total amount paid from both the temuans and pembayarans tables

        $totalDibayarTemuan = Temuan::sum('nilai_telah_dibayar');
        $totalDibayarPembayaran = Pembayaran::sum('jumlah_pembayaran');
        $jumlahDibayar = $nilaidibayar;

        // Get the remaining amount to be paid


        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua temuan per tahun dan bulan
            $temuanPerYearMonth = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('MONTH(tgl_lhp) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('YEAR(tgl_lhp)'), DB::raw('MONTH(tgl_lhp)'))
                ->get()
                ->groupBy('year');
        } else {
            // OPD Admin melihat temuan mereka per tahun dan bulan
            $temuanPerYearMonth = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('MONTH(tgl_lhp) as month'), DB::raw('count(*) as total'))
                ->where('temuans.opd_id', $user->opd_id)
                ->groupBy(DB::raw('YEAR(tgl_lhp)'), DB::raw('MONTH(tgl_lhp)'))
                ->get()
                ->groupBy('year');
        }

        // Chart for OPD: total recommendations and payments
        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua data pembayaran per OPD
            $sisaPembayaranPerOpd = Temuan::select('opds.opd_name', DB::raw('SUM(nilai_rekomendasi) as total_rekomendasi'), DB::raw('SUM(pembayarans.jumlah_pembayaran) as total_pembayaran'))
                ->join('opds', 'temuans.opd_id', '=', 'opds.id')
                ->leftJoin('pembayarans', 'temuans.id', '=', 'pembayarans.temuan_id')
                ->whereYear('tgl_lhp', $year)
                ->groupBy('opds.opd_name')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->opd_name => $item->total_rekomendasi - $item->total_pembayaran];
                });
        } else {
            // OPD Admin melihat data pembayaran hanya untuk OPD mereka
            $sisaPembayaranPerOpd = Temuan::select('opds.opd_name', DB::raw('SUM(nilai_rekomendasi) as total_rekomendasi'), DB::raw('SUM(pembayarans.jumlah_pembayaran) as total_pembayaran'))
                ->join('opds', 'temuans.opd_id', '=', 'opds.id')
                ->leftJoin('pembayarans', 'temuans.id', '=', 'pembayarans.temuan_id')
                ->where('temuans.opd_id', $user->opd_id)
                ->whereYear('tgl_lhp', $year)
                ->groupBy('opds.opd_name')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->opd_name => $item->total_rekomendasi - $item->total_pembayaran];
                });
        }

        // Count of findings per OPD
        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat jumlah temuan per OPD
            $TemuanPerOpd = Temuan::select('opds.opd_name', DB::raw('COUNT(*) as total_temuan'))
                ->join('opds', 'temuans.opd_id', '=', 'opds.id')
                ->whereYear('tgl_lhp', $year)
                ->groupBy('opds.opd_name')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->opd_name => $item->total_temuan];
                });
        } else {
            // OPD Admin melihat jumlah temuan hanya untuk OPD mereka
            $TemuanPerOpd = Temuan::select('opds.opd_name', DB::raw('COUNT(*) as total_temuan'))
                ->join('opds', 'temuans.opd_id', '=', 'opds.id')
                ->where('temuans.opd_id', $user->opd_id)
                ->whereYear('tgl_lhp', $year)
                ->groupBy('opds.opd_name')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->opd_name => $item->total_temuan];
                });
        }


        $currentYear = date('Y');

        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua tahun dalam data temuan
            $years = Temuan::selectRaw('YEAR(tgl_lhp) as year')
                ->distinct()
                ->pluck('year')
                ->toArray();

            // Ambil data temuan per hari dalam bulan tertentu pada tahun ini
            $temuanPerDayInMonth = Temuan::selectRaw('DATE(tgl_lhp) as date, COUNT(*) as count')
                ->whereYear('tgl_lhp', $currentYear)
                ->groupBy('date')
                ->get();

            // Ambil data temuan per bulan dalam tahun tertentu
            $temuanPerMonth = Temuan::selectRaw('YEAR(tgl_lhp) as year, MONTH(tgl_lhp) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->get();

            // Ambil data jumlah temuan per OPD
            $temuanPerOPD = Temuan::selectRaw('opd_id, COUNT(*) as count')
                ->groupBy('opd_id')
                ->get();

            // Ambil nama OPD berdasarkan opd_id
            $opds = OPD::all()->pluck('opd_name', 'id');

            // Data temuan per status
            $temuanStatus = DB::table('temuans')
                ->join('statuses', 'temuans.status_id', '=', 'statuses.id')
                ->selectRaw('YEAR(temuans.tgl_lhp) as year, statuses.status as status_name, COUNT(*) as count')
                ->groupBy('year', 'status_name')
                ->get();

            // Group data by year (based on tgl_lhp) and TGR status
            $temuanPerStatusTGR = Temuan::selectRaw('YEAR(tgl_lhp) as year, statustgr_id, COUNT(*) as count')
                ->groupBy('year', 'statustgr_id')
                ->orderBy('year')
                ->get();

            // Get the TGR status names
            $statusTGRs = Statustgr::all()->pluck('tgr_name', 'id');

            // Jumlah OPD yang memiliki temuan
            $jumlahOPDTemuan = Temuan::select('opd_id')
                ->distinct()
                ->count('opd_id');
        } else {
            // OPD Admin melihat data hanya untuk OPD mereka
            $years = Temuan::selectRaw('YEAR(tgl_lhp) as year')
                ->where('opd_id', $user->opd_id)
                ->distinct()
                ->pluck('year')
                ->toArray();

            $temuanPerDayInMonth = Temuan::selectRaw('DATE(tgl_lhp) as date, COUNT(*) as count')
                ->where('opd_id', $user->opd_id)
                ->whereYear('tgl_lhp', $currentYear)
                ->groupBy('date')
                ->get();

            $temuanPerMonth = Temuan::selectRaw('YEAR(tgl_lhp) as year, MONTH(tgl_lhp) as month, COUNT(*) as count')
                ->where('opd_id', $user->opd_id)
                ->groupBy('year', 'month')
                ->get();

            $temuanPerOPD = Temuan::selectRaw('opd_id, COUNT(*) as count')
                ->where('opd_id', $user->opd_id)
                ->groupBy('opd_id')
                ->get();

            $opds = OPD::where('id', $user->opd_id)->pluck('opd_name', 'id');

            $temuanStatus = DB::table('temuans')
                ->join('statuses', 'temuans.status_id', '=', 'statuses.id')
                ->selectRaw('YEAR(temuans.tgl_lhp) as year, statuses.status as status_name, COUNT(*) as count')
                ->where('temuans.opd_id', $user->opd_id)
                ->groupBy('year', 'status_name')
                ->get();

            $temuanPerStatusTGR = Temuan::selectRaw('YEAR(tgl_lhp) as year, statustgr_id, COUNT(*) as count')
                ->where('opd_id', $user->opd_id)
                ->groupBy('year', 'statustgr_id')
                ->orderBy('year')
                ->get();

            $statusTGRs = Statustgr::all()->pluck('tgr_name', 'id');

            $jumlahOPDTemuan = Temuan::where('opd_id', $user->opd_id)
                ->distinct()
                ->count('opd_id');
        }

        return view('dashboard', compact(
            'temuans',
            'jumlahTemuan',
            'jumlahRekomendasi',
            'jumlahDibayar',
            'year',
            'availableYears',
            'jumlahTemuanStatus',
            'jumlahTemuanTahun',
            'temuanPerYearMonth',
            'months',
            'counts',
            'sisaBayar',
            'sisaPembayaranPerOpd',
            'years',
            'temuanPerDayInMonth',
            'temuanPerMonth',
            'temuanPerOPD',
            'opds',
            'temuanStatus',
            'temuanPerStatusTGR',
            'statusTGRs',
            'jumlahOPDTemuan'
        ));
    }


    // public function getTemuanPerBulan(Request $request)
    // {
    //     $year = $request->input('year', Carbon::now()->year);
    //     $user = Auth::user(); // Mendapatkan pengguna yang terautentikasi

    //     // Inisialisasi query berdasarkan peran pengguna
    //     if ($user->hasRole('Super Admin')) {
    //         $temuanQuery = Temuan::query();
    //     } else {
    //         $temuanQuery = Temuan::where('opd_id', $user->opd_id);
    //     } else {
    //         return response()->json([
    //             'message' => 'Unauthorized action.'
    //         ], 403);
    //     }

    //     // Mengambil data temuan per bulan untuk tahun yang dipilih
    //     $temuan = $temuanQuery->selectRaw('MONTH(tgl_lhp) as month, COUNT(*) as count')
    //         ->whereYear('tgl_lhp', $year)
    //         ->groupBy('month')
    //         ->get();

    //     $months = [];
    //     $counts = [];

    //     // Mengisi data untuk setiap bulan
    //     for ($i = 1; $i <= 12; $i++) {
    //         $monthData = $temuan->firstWhere('month', $i);
    //         $months[] = Carbon::create()->month($i)->format('F');
    //         $counts[] = $monthData ? $monthData->count : 0;
    //     }

    //     return response()->json([
    //         'months' => $months,
    //         'counts' => $counts,
    //     ]);
    // }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
