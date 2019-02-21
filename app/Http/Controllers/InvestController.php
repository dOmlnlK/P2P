<?php

namespace App\Http\Controllers;
use Auth;
use App\Bid;
use App\Pro;
use DemeterChain\B;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestController extends Controller
{
    public function invest($pid){

        $pro = Pro::find($pid);
        return view('invest',compact('pro'));
    }

    public function investPost(Request $req,$pid){
        $pro = Pro::find($pid);
        $user = Auth::user();

        //添加投标记录
        $bid = new Bid();
        $bid->uid = $user->uid;
        $bid->pid = $pid;
        $bid->money = \request('money') * 100;
        $bid->title = $pro->title;
        $bid->pubtime = time();

        $bid->save();

        //更新项目中的recive字段
        $pro->recive += $bid->money;
        $pro->save();

        //投资项目筹款完成
        if($pro->recive == $pro->money){
            $this->investDone($pid);
        }

        return '投资成功!';

    }

    public function investDone($pid){
        //1.修改项目状态
        $pro = Pro::find($pid);
        $pro->status = 2;
        $pro->save();

        //2.为筹款人生成还款账单
        //每月还款金额(本金+利息)
        $amount = $pro->money / $pro->hrange + ($pro->money * $pro->rate)/1200;
        $data = ['uid'=>$pro->uid,'pid'=>$pro->pid,'title'=>$pro->title,'amount'=>$amount];

        for($i=1;$i<=$pro->hrange;$i++){
            //还款日期
            $paydate = date('Y-m-d',strtotime("+ $i months"));
            $data['paydate'] = $paydate;
            DB::table('replayments')->insert($data);

        }

        //3.为每个投资人生成预收益账单
        $bids = Bid::where('pid',$pid)->get();

        $row = ['pid'=>$pid,'title'=>$pro->title,'enddate'=>$paydate];
        foreach ($bids as $bid){
            //每日利息收益
            $amount = ($bid->money * $pro->rate) / 36500;
            $row['amount'] = $amount;
            $row['uid'] = $bid->uid;

            DB::table('tasks')->insert($row);

        }

    }
}
