<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Subscription_reportsExport;
use App\Http\Controllers\ReportesController;

class Subscription_reportsController extends Controller
{
    public function export(Request $request) {
        Excel::queue(new Subscription_reportsExport($request->fecha1, $request->fecha2), 'reporte.xlsx', 'public');

        return redirect()->action([ReportesController::class, 'index']);
    }
}
