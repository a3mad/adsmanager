<?php

namespace App\Http\Controllers;

use App\Models\OutdoorReport;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OutdoorReportController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $request->validate([
            'outdoor_location_id' => 'required',
            'date_from' => 'required_with:date_to|date_format:Y-m-d',
            'date_to' => 'required_with:date_from|date_format:Y-m-d|after_or_equal:date_from',
        ]);
        $data = OutdoorReport::where('outdoor_location_id', '=', $request->input('outdoor_location_id'));
        if ($request->input('date_from') && $request->input('date_to')) {
            $data->whereBetween('report_date', [$request->input('date_from'), $request->input('date_to')]);
        }
        $data->orderBy('report_date','desc');
        return $this->successResponse($data->get());
    }
}
