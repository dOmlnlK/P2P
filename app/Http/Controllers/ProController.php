<?php

namespace App\Http\Controllers;
use App\Rules\checkCode;
use Validator;
use Gregwar\Captcha\CaptchaBuilder;

use Illuminate\Http\Request;
use App\Attr;
use App\Pro;
use Auth;
use Illuminate\Support\Facades\DB;

class ProController extends Controller
{
    //
    public function loan(){
        return view('loan');
    }

    public function loanPost(){
        $validator = Validator::make(\request()->all(),[
            'imgcode' => ['required',new checkCode()],
        ],['required'=>'验证码不能为空！']);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }



        DB::beginTransaction();
        $user = Auth::user();

        try{
            $pro = Pro::create([
                'money' => \request('money')*100,
                'mobile' => \request('mobile'),
                'uid' => $user->uid,
                'name' => $user->name,
                'pubtime' => time()
            ]);
        }catch (\Exception $e){

            DB::rollback();
            throw $e;
        }

        try{
//            dd($pro);
            $attr = Attr::create([
                'pid' => $pro->pid,
                'uid' => $user->uid,
                'age' => \request('age'),
                'pubtime' => time()
            ]);
        }catch (\Exception $e){

            DB::rollback();
            throw $e;
        }

        DB::commit();
        return '申请成功！';

    }

    public function captcha(){
        $builder = new CaptchaBuilder;
        $builder->build();
        $builder->output();

        session(['checkCode'=>strtolower($builder->getPhrase())]);
    }

}
