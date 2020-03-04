<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Login\LiwuModel;
use App\Login\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

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
                $key='yk';
                Redis::set($key,$username);
//                $url="http://swoole.1548580932.top";
                return redirect("/index");
            }else{
                dd("密码错误");
            }
        }else{
            dd('用户名不存在');
        }
    }

    public function reg(){
        return view('/login/reg');
    }

    public function regdo(){
        $data=request()->input();
        if(!preg_match("/^1[34578]\d{9}$/", $data['tel'])){
            echo "手机号有误";die;
        }
//        dd($data);
        $res=LoginModel::insert($data);
        if($res){
            return redirect('/');
        }
    }

    public function index(){
        $res=LiwuModel::get()->toArray();
//        dd($res);
        $key="yk";
        $data=Redis::get($key);
        return view('/index',['data'=>$data,'res'=>$res]);
    }
    public function checkliwu(Request $request){

        $id=$request->input('id');
        $username=$request->input('username');
//        echo $username;
        $res=LiwuModel::where('id',$id)->first();

        $res1=LoginModel::where('username',$username)->first();
//        return $res1;m
        $data=$res1['mem']+$res['mem'];
//        return $data;

        $res2=LoginModel::where('username',$username)->update(['mem'=>$data]);
        echo $res2;
    }
}
