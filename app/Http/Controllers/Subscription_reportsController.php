<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Subscription_reportsExport;

class Subscription_reportsController extends Controller
{
    public function export(Request $request) {
        return Excel::download(new Subscription_reportsExport($request->fecha1, $request->fecha2), 'reporte.xlsx');
    }
}
