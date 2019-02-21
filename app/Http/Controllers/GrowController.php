<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class GrowController extends Controller
{
    //为每日收益的用户拨款
    public function grow(){
        $today = date('Y-m-d');
        //找出所有有效的预收益账单
        $tasks = DB::table('tasks')->where('enddate','>=',$today)->get();

        foreach ($tasks as $t){
            //把对象转化为数组
            $t = (array)$t;
            unset($t['tid']);
            unset($t['enddate']);
            $t['paytime'] = $today;
            DB::table('grows')->insert($t);
        }

        return '拨款成功!';
    }

}
