<?php

namespace App\Http\Controllers;

use App\Support\GValue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Support\Response;
//use App\Http\Requests\Request;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response;

    public function init(Request $request){
        $this->response = new Response();
        if(false === GValue::$ajax && 'GET' === GValue::$httpMethod){
            //
        }
    }



}
