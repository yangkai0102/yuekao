<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Login\LoginModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login(){
        return view('/login/login');
    }

    public function logindo(){
        $username=request()->input('username');
        $pwd=request()->input('password');
        $where=
            ['username'=>$username];
        $res=LoginModel::where($where)->first()->toArray();
//        dd($res);
        if($res){
            if($pwd==$res['pwd']){
                $url="http://swoole.1548580932.top";
                return redirect($url);
            }
        }else{
            dd('用户名不存在');
        }
    }

    public function reg(){
        return view('/login/reg');
    }
}
