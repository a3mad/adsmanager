<?php

namespace App\Http\Controllers;

use App\Models\OutdoorLocation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class OutdoorLocationController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $data=OutdoorLocation::all();
        return $this->successResponse($data);
    }
}
