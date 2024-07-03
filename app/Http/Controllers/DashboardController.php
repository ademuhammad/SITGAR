<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:dashboard-list', ['only' => ['index', 'show', 'getTemuanPerBulan']]);
    }
    public function index(Request $request)
    {
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

        $jumlahTemuanTahun = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('YEAR(tgl_lhp)'))
            ->pluck('total', 'year');

        $jumlahTemuan = Temuan::all()->count();
        $jumlahRekomendasi = $temuans->sum('nilai_rekomendasi');

        $jumlahTemuanStatus = Temuan::join('statuses', 'temuans.status_id', '=', 'statuses.id')
            ->select('statuses.status as status', DB::raw('count(*) as total'))
            ->groupBy('statuses.status')
            ->pluck('total', 'status');

        $dibayar = Pembayaran::all();
        $jumlahDibayar = $dibayar->sum('jumlah_pembayaran');

        // Calculate the remaining amount to be paid
        $sisaBayar = $jumlahRekomendasi - $jumlahDibayar;

        $temuanPerYearMonth = Temuan::select(DB::raw('YEAR(tgl_lhp) as year'), DB::raw('MONTH(tgl_lhp) as month'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('YEAR(tgl_lhp)'), DB::raw('MONTH(tgl_lhp)'))
            ->get()
            ->groupBy('year');

        // chart opd
        $sisaPembayaranPerOpd = Temuan::select('opds.opd_name', DB::raw('SUM(nilai_rekomendasi - jumlah_pembayaran) as sisa_pembayaran'))
            ->join('opds', 'temuans.opd_id', '=', 'opds.id')
            ->leftJoin('pembayarans', 'temuans.id', '=', 'pembayarans.temuan_id')
            ->whereYear('tgl_lhp', $year)
            ->groupBy('opds.opd_name')
            ->pluck('sisa_pembayaran', 'opds.opd_name');

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
            'sisaPembayaranPerOpd'
        ));
    }
    public function getTemuanPerBulan(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);

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

        return response()->json([
            'months' => $months,
            'counts' => $counts,
        ]);
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
