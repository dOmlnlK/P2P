<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('grow', function () {
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
})->describe('每日打款');
