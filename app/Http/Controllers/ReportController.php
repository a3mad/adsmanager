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
        $sponsor_types = DB::table('sponsor_types')
            ->leftJoin('reports','sponsor_types.id', '=', 'reports.sponsor_type_id')
            ->select('sponsor_types.name', DB::raw('count(reports.sponsor_type_id) as total'))
            ->groupBy('sponsor_types.name')
            ->get();
        $locations = DB::table('locations')
            ->leftJoin('reports','locations.id', '=', 'reports.location_id')
            ->select('locations.name', DB::raw('count(reports.location_id) as total'))
            ->groupBy('locations.name')
            ->get();
        $program_breaks = DB::table('program_breaks')
            ->leftJoin('reports','program_breaks.id', '=', 'reports.program_break_id')
            ->select('program_breaks.name', DB::raw('count(reports.program_break_id) as total'))
            ->groupBy('program_breaks.name')
            ->get();
        $reruns = DB::table('reruns')
            ->leftJoin('reports','reruns.id', '=', 'reports.rerun_id')
            ->select('reruns.name', DB::raw('count(reports.rerun_id) as total'))
            ->groupBy('reruns.name')
            ->get();
        $air_time = DB::table('reports')
            ->select(DB::raw('hour(air_time) as hour'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('hour(air_time)'))
            ->get();

        $data=[
            'sponsor_types' => $sponsor_types,
            'locations'=>$locations,
            'program_breaks'=>$program_breaks,
            'reruns'=>$reruns,
            'air_time'=>$air_time,
        ];
        return $this->successResponse($data);
    }
}
