<?php

namespace App\Http\Controllers;

use App\Models\DigitalReport;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DigitalReportController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $request->validate([
            'program_id'=>'required',
            'date_from' => 'required_with:date_to|date_format:Y-m-d',
            'date_to' => 'required_with:date_from|date_format:Y-m-d|after_or_equal:date_from',
        ]);
        $data=DigitalReport::where('program_id','=',$request->input('program_id'));
        if ($request->input('date_from') && $request->input('date_to')) {
            $data->whereBetween('item_date', [$request->input('date_from'), $request->input('date_to')]);
        }else{
            $data->whereBetween('item_date', [Carbon::yesterday(),Carbon::now()]);
        }
        return $this->successResponse($data->get());
    }
}
