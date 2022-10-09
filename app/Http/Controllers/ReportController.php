<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponser;

class ReportController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'date_from' => 'required_with:date_to|date_format:Y-m-d',
            'date_to' => 'required_with:date_from|date_format:Y-m-d|after_or_equal:date_from',
            'time_from' => 'required_with:time_to|date_format:H:i:s',
            'time_to' => 'required_with:time_from|date_format:H:i:s|after_or_equal:time_from',
            'duration_from' => 'required_with:duration_to|numeric|between:1,1000',
            'duration_to' => 'required_with:duration_from|numeric|between:1,1000|gte:duration_from',
            'campaign_id' => '',
            'location_id' => '',
            'sponsor_type_id' => '',
            'rerun_id' => '',
            'break_id' => '',
        ]);
        $sponsor_types = DB::table('sponsor_types')
            ->leftJoin('reports', 'sponsor_types.id', '=', 'reports.sponsor_type_id')
            ->select('sponsor_types.id', 'sponsor_types.name', DB::raw('count(reports.sponsor_type_id) as total'))
            ->groupBy('sponsor_types.id', 'sponsor_types.name');
        $locations = DB::table('locations')
            ->leftJoin('reports', 'locations.id', '=', 'reports.location_id')
            ->select('locations.id', 'locations.name', DB::raw('count(reports.location_id) as total'))
            ->groupBy('locations.id', 'locations.name');
        $program_breaks = DB::table('program_breaks')
            ->leftJoin('reports', 'program_breaks.id', '=', 'reports.program_break_id')
            ->select('program_breaks.id', 'program_breaks.name', DB::raw('count(reports.program_break_id) as total'))
            ->groupBy('program_breaks.id', 'program_breaks.name');
        $reruns = DB::table('reruns')
            ->leftJoin('reports', 'reruns.id', '=', 'reports.rerun_id')
            ->select('reruns.id', 'reruns.name', DB::raw('count(reports.rerun_id) as total'))
            ->groupBy('reruns.id', 'reruns.name');
        $air_time = DB::table('reports')
            ->select(DB::raw('hour(air_time) as hour'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('hour(air_time)'));

        $data = [
            'sponsor_types' => $sponsor_types,
            'locations' => $locations,
            'program_breaks' => $program_breaks,
            'reruns' => $reruns,
            'air_time' => $air_time,
        ];
        foreach ($data as $key => &$value) {
            if ($request->input('date_from') && $request->input('date_to')) {
                $value->whereBetween('air_date', [$request->input('date_from'), $request->input('date_to')]);
            }
            if ($request->input('time_from') && $request->input('time_to')) {
                $value->whereBetween('air_time', [$request->input('time_from'), $request->input('time_to')]);
            }
            if ($request->input('duration_from') && $request->input('duration_to')) {
                $value->whereBetween('duration', [$request->input('duration_from'), $request->input('duration_to')]);
            }
            if ($request->input('duration_from') && $request->input('duration_to')) {
                $value->whereBetween('duration', [$request->input('duration_from'), $request->input('duration_to')]);
            }
            if ($request->input('campaign_id')) {
                $value->where('campaign_id', '=', $request->input('campaign_id'));
            }
            if ($request->input('location_id')) {
                $value->where('location_id', '=', $request->input('location_id'));
            }
            if ($request->input('sponsor_type_id')) {
                $value->where('sponsor_type_id', '=', $request->input('sponsor_type_id'));
            }
            if ($request->input('campaign_id')) {
                $value->where('rerun_id', '=', $request->input('rerun_id'));
            }
            if ($request->input('break_id')) {
                $value->where('program_break_id', '=', $request->input('break_id'));
            }
            $value = $value->get();
        }

        return $this->successResponse($data);
    }
}
