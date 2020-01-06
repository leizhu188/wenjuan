<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
    protected $pwd = '123321';

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

    public function makeWenjuan(){
        $timus = json_decode(Redis::get('timu'),true);
        $datas = [
            'timus' => $timus,
            'pwd_error' => Session::get('pwd_error'),
            'make_success' => Session::get('make_success'),
        ];

        return view('make',$datas);
    }

    public function doMakeWenjuan(Request $request){
        if (!$request->get('pwd') || $request->get('pwd') != $this->pwd){
            return redirect('makeWenjuan')->with('pwd_error',1);
        }

        $xuanzeList = [];
        $tiankongList = [];
        foreach ($request->all() as $k=>$v){
            if (empty($v)){
                continue;
            }
            if (count(explode('choose_q',$k))>1){
                $xuanzeList[(int)trim($k,'choose_q')]['q'] = $v;
                continue;
            }
            if (count(explode('choose_',$k))>1){
                $arr = explode('_',$k);
                $xuanzeList[(int)$arr[1]]['as'][$arr[2]] = $v;
                continue;
            }
            if (count(explode('tiankong_q',$k))>1){
                $tiankongList[(int)trim($k,'tiankong_q')] = $v;
                continue;
            }
        }

        $timus = [
            'xuanze_list'   => array_values($xuanzeList),
            'tiankong_list' => array_values($tiankongList)
        ];

        Redis::set('timu',json_encode($timus));

        return redirect('makeWenjuan')->with('make_success',1);
    }


//    public function test(Request $request){
//        $timu = [
//            'xuanze_list'=>[
//                [
//                    'q'=>'是否满意？',
//                    'as'=>[
//                        'A'=>'满意',
//                        'B'=>'一般',
//                        'C'=>'不满意'
//                    ]
//                ],
//                [
//                    'q'=>'是否喜欢？',
//                    'as'=>[
//                        'A'=>'喜欢',
//                        'B'=>'一般',
//                        'C'=>'不喜欢'
//                    ]
//                ]
//            ],
//            'tiankong_list'=>[
//                '有什么意见？'
//            ],
//        ];
//        Redis::set('timu',json_encode($timu));
//        dd(Redis::get('timu'));
//    }
}
