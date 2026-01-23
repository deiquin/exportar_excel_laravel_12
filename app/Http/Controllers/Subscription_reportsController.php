<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Subscription_reportsExport;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\DateTime;

class Subscription_reportsController extends Controller
{
    public function export(Request $request) {
        //return Excel::download(new Subscription_reportsExport, 'reporte.xlsx');
        return Excel::download(new Subscription_reportsExport($request->fecha1, $request->fecha2), 'reporte.xlsx');
        //return $request->fecha1 . " -- " . $request->fecha2 ;

    }
}
