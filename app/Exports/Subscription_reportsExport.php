<?php

namespace App\Exports;

use App\Models\Subscription_report;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscription_reportsExport implements FromQuery, WithHeadings,  WithStyles, ShouldQueue, WithChunkReading
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $fecha1 = '';
    public $fecha2 = '';

    public function __construct($fecha1, $fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }

    public function query()
    {
        $first = Subscription_report::select('subscription_reports.id AS ID', 
                    'subscriptions.full_name AS NOMBRE_COMPLETO', 
                    'subscriptions.document AS DNI', 'subscriptions.email AS EMAIL', 
                    'subscriptions.phone AS TELEFONO', 'report_credit_cards.bank AS COMPANIA',
                    DB::raw("'TARJETA DE CREDITO' as TIPO_DE_DEUDA"),
                    DB::raw("'' as SITUACION"),
                    DB::raw("'' as ATRASO"),
                    'report_credit_cards.bank AS ENTIDAD', 'report_credit_cards.used AS MONTO_TOTAL',
                    'report_credit_cards.line AS LINEA_TOTAL', 'report_credit_cards.used AS LINEA_USADA',
                    'subscription_reports.created_at AS REPORTE_SUBIDO_EL', 
                    DB::raw("'ACTIVO' as ESTADO"))
                ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscription_reports.subscription_id')
                ->leftJoin('report_credit_cards', 'report_credit_cards.subscription_report_id', '=', 'subscription_reports.id')
                ->where('subscription_reports.created_at', '>', $this->fecha1)
                ->where('subscription_reports.created_at', '<', $this->fecha2);

        $second = Subscription_report::select('subscription_reports.id AS ID', 
                    'subscriptions.full_name AS NOMBRE_COMPLETO', 
                    'subscriptions.document AS DNI', 'subscriptions.email AS EMAIL', 
                    'subscriptions.phone AS TELEFONO', 'report_loans.bank AS COMPANIA',
                    DB::raw("'PRESTAMO' as TIPO_DE_DEUDA"),
                    'report_loans.status AS SITUACION',
                    'report_loans.expiration_days AS ATRASO',
                    'report_loans.bank AS ENTIDAD',
                    'report_loans.amount AS MONTO_TOTAL',
                    DB::raw("'' as LINEA_TOTAL"),
                    DB::raw("'' as LINEA_USADA"),
                    'subscription_reports.created_at AS REPORTE_SUBIDO_EL', 
                    DB::raw("'ACTIVO' as ESTADO"))
                ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscription_reports.subscription_id')
                ->leftJoin('report_loans', 'report_loans.subscription_report_id', '=', 'subscription_reports.id')
                ->where('subscription_reports.created_at', '>', $this->fecha1)
                ->where('subscription_reports.created_at', '<', $this->fecha2)
                ->union($first);

        $third = Subscription_report::select('subscription_reports.id AS ID', 
                    'subscriptions.full_name AS NOMBRE_COMPLETO', 
                    'subscriptions.document AS DNI', 'subscriptions.email AS EMAIL', 
                    'subscriptions.phone AS TELEFONO', 'report_other_debts.entity AS COMPANIA',
                    DB::raw("'OTRA DEUDA' as TIPO_DE_DEUDA"),
                    DB::raw("'' as SITUACION"),
                    'report_other_debts.expiration_days AS ATRASO',
                    'report_other_debts.entity AS ENTIDAD',
                    'report_other_debts.amount AS MONTO_TOTAL,',
                    DB::raw("'' as LINEA_TOTAL"),
                    DB::raw("'' as LINEA_USADA"),
                    'subscription_reports.created_at AS REPORTE_SUBIDO_EL', 
                    DB::raw("'ACTIVO' as ESTADO"))
                ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscription_reports.subscription_id')
                ->leftJoin('report_other_debts', 'report_other_debts.subscription_report_id', '=', 'subscription_reports.id')
                ->where('subscription_reports.created_at', '>', $this->fecha1)
                ->where('subscription_reports.created_at', '<', $this->fecha2)
                ->union($second)
                ->orderBy('ID');

        return $third;
 }

    public function headings(): array 
    {
        return ['ID', 'NOMBRE_COMPLETO', 'DNI', 'EMAIL', 'TELEFONO','COMPANIA', 
        'TIPO_DE_DEUDA', 'SITUACION', 'ATRASO', 'ENTIDAD', 'MONTO_TOTAL',
        'LINEA_TOTAL', 'LINEA_USADA', 'REPORTE_SUBIDO_EL', 'ESTADO'];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // fila 1 en negrita
        ];
    }
}                                  