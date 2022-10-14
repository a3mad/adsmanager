<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'date_from' => 'required_with:date_to|date_format:Y-m-d',
            'date_to' => 'required_with:date_from|date_format:Y-m-d|after_or_equal:date_from',
        ]);
        $data = QrCode::where('program_id', '=', $request->input('program_id'));
        if ($request->input('date_from') && $request->input('date_to')) {
            $data->whereBetween('created_at', [$request->input('date_from'), $request->input('date_to')]);
        } else {
            $data->whereBetween('created_at', [Carbon::yesterday(), Carbon::now()]);
        }
        return $this->successResponse($data->get());
    }
}
