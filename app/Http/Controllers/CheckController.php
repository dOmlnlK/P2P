<?php

namespace App\Http\Controllers;
use App\Pro;
use App\Attr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    //
    public function prolist(){
        //获取所有借款项目
        $pro_list = Pro::orderby('pid','desc')->get();

        return view('prolist',compact('pro_list'));
    }

    public function check($pid){

        $mon = Pro::where('pid',$pid)->value('money');
        return view('check',compact('mon'));
    }

    public function checkPost($pid){
        $pro = Pro::find($pid);
        $attr = Attr::where('pid',$pid)->first();

        DB::beginTransaction();
        try{
            $pro->status = \request('status');
            $pro->hrange = \request('hrange');
            $pro->rate = \request('rate');
            $pro->title = \request('title');

            $pro->save();
        }catch (\Exception $e){

            DB::rollback();
            throw $e;
        }

        try{
            $attr->title = \request('title');
            $attr->realname = \request('realname');
            $attr->udesc = \request('udesc');
            $attr->gender = \request('gender');

            $attr->save();

        }catch (\Exception $e){

            DB::rollback();
            throw $e;
        }

        DB::commit();
        return redirect('prolist');
    }
}
