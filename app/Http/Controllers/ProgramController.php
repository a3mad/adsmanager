<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    use ApiResponser;
    public function index(Request $request){
        $data=Program::all();
        return $this->successResponse($data);
    }
}
