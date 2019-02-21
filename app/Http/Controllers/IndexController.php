<?php

namespace App\Http\Controllers;
use Auth;
use App\Pro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index(){
        //取出已经审核的项目
        $pro_list = Pro::where('status',1)->orderby('pid','desc')->get();

        return view('index',compact('pro_list'));
    }

    public function mybill(){
        $replays = DB::table('replayments')->where('uid',Auth::id())->paginate(3);

        return view('mybill',compact('replays'));
    }

    public function mybid(){
        $bids = DB::table('bids')->
        where('bids.uid',Auth::id())->whereIn('status',['1','2'])->
        join('projects','bids.pid','=','projects.pid')->get();

        return view('mybid',compact('bids'));
    }

    public function mygrow(){
        $grows = DB::table('grows')->where('uid',Auth::id())->get();
        return view('mygrow',compact('grows'));
    }
}
