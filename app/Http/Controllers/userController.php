<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class userController extends Controller
{
    public function test(Request $request){
        $timu = [
            'xuanze_list'=>[
                [
                    'q'=>'是否满意？',
                    'as'=>[
                        'A'=>'满意',
                        'B'=>'一般',
                        'C'=>'不满意'
                    ]
                ],
                [
                    'q'=>'是否喜欢？',
                    'as'=>[
                        'A'=>'喜欢',
                        'B'=>'一般',
                        'C'=>'不喜欢'
                    ]
                ]
            ],
            'tiankong_list'=>[
                '有什么意见？'
            ],
        ];
        Redis::set('timu',json_encode($timu));
        dd(Redis::get('timu'));
    }

    public function timu(){
        $timu = Redis::get('timu');
        return view('wenjuan',['timu'=>json_decode($timu,true)]);
    }

    public function saveAnswer(Request $request){
        $ansers = Redis::get('answers');
        $ansers = $ansers ? json_decode($ansers,true) : [];
        $anser = [];
        foreach ($request->all() as $k=>$v){
            if ($k == '_token'){
                continue;
            }
            if (count(explode('_',$k)) > 1){
                $anser[explode('_',$k)[0]][(int)explode('_',$k)[1]] = $v;
                continue;
            }
            $anser[$k] = $v;
        }

        $ansers []= $anser;
        Redis::set('answers',json_encode($ansers));
        return view('ok');
    }

    public function listAnswers(){
        return Redis::get('answers');
    }
}
