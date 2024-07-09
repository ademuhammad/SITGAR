<?php
namespace App\Exports;

use App\Models\Temuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class DataExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $filters;
    protected $totalDibayar = 0;
    protected $totalKerugian = 0;
    protected $totalSisaBayar = 0;
    protected $rowNumber = 1;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Temuan::query()->with('status', 'pembayarans');

        if ($this->filters['opd_id']) {
            $query->where('opd_id', $this->filters['opd_id']);
        }
        if ($this->filters['status_id']) {
            $query->where('status_id', $this->filters['status_id']);
        }
        if ($this->filters['no_lhp']) {
            $query->where('no_lhp', 'like', '%' . $this->filters['no_lhp'] . '%');
        }
        if ($this->filters['start_date']) {
            $query->whereDate('tgl_lhp', '>=', $this->filters['start_date']);
        }
        if ($this->filters['end_date']) {
            $query->whereDate('tgl_lhp', '<=', $this->filters['end_date']);
        }

        $temuans = $query->get();

        // Calculate totals
        $this->totalDibayar = $temuans->sum(function($temuan) {
            return $temuan->pembayarans->sum('jumlah_pembayaran');
        });

        $this->totalKerugian = $temuans->sum('nilai_rekomendasi');
        $this->totalSisaBayar = $temuans->sum('sisa_nilai_uang');

        return $temuans;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'No LHP',
            'Sumber Informasi',
            'Nama OPD',
            'Status',
            'Tgl LHP',
            'Obrik Pemeriksaan',
            'Temuan',
            'Rekomendasi',
            'Jumlah Kerugian',
            'Telah Dibayar',
            'Sisa Kerugian',
            'Jumlah Bulan Bayar',
            'Total Jumlah Dibayar',
            'Total Jumlah Kerugian',
            'Total Sisa Bayar',
            '', // Leave blank for totals row
            '', // Leave blank for totals row
            '', // Leave blank for totals row
        ];
    }

    /**
     * @param mixed $temuan
     * @return array
     */
    public function map($temuan): array
    {
        // Menghitung jumlah bulan pembayaran
        $jumlahBulanBayar = $temuan->pembayarans->groupBy(function($date) {
            return Carbon::parse($date->tgl_pembayaran)->format('Y-m');
        })->count();

        return [
            $this->rowNumber++, // Add this line to include row number
            $temuan->no_lhp,
            $temuan->sumber_informasi,
            $temuan->opd_name,
            $temuan->status->status, // Ensure this is the name of the column in the status table
            $temuan->tgl_lhp,
            $temuan->obrik_pemeriksaan,
            $temuan->temuan,
            $temuan->rekomendasi,
            number_format($temuan->nilai_rekomendasi, 2),
            number_format($temuan->nilai_telah_dibayar, 2),
            number_format($temuan->sisa_nilai_uang, 2),
            $jumlahBulanBayar,
            number_format($this->totalDibayar, 2),
            number_format($this->totalKerugian, 2),
            number_format($this->totalSisaBayar, 2),
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'N' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'O' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
