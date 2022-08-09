<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ResponseController extends Controller
{
    public function Success($msg , $data , $code=Response::HTTP_OK){
        return response()->json([
            'status'=> Response::HTTP_OK ,
            "msg"=>$msg ,
            'data'=>$data
        ] , $code);
    }

    public function Error($msg , $data , $code=Response::HTTP_FORBIDDEN){
        return response()->json([
            'status'=> Response::HTTP_FORBIDDEN,
            'msg'=>$msg,
            'data'=>$data
        ],$code);
    }
}
