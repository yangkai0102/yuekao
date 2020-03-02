<?php

namespace App\Http\Controllers\Hotel;

use App\Hotel\Swiper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwiperController extends Controller
{
    //
    function index(){
        $data=Swiper::where('status',1)->get();
        dd($data);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);

    }
}
