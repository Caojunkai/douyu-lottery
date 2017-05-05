<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $vote_time = DB::table('gifts')->select('vote_id', DB::raw('MAX(vote_time) as end_time'), DB::raw('MIN(vote_time) as start_time'))->groupBy('vote_id')->orderBy('start_time', 'desc')->paginate();
        $is_luck_draw = DB::table('lucks')->pluck('vote_id')->toArray();
        foreach ($vote_time->items() as $key => $value) {
            if (in_array($value->vote_id, $is_luck_draw, true)) {
                $vote_time->items()[$key]->is_draw = true;
            } else {
                $vote_time->items()[$key]->is_draw = false;
            }
        }
        return view('douyu.lottery', ['vote_times' => $vote_time]);
    }

    public function show($lottery, Request $request) {
        $vote_list = DB::table('gifts')->select(DB::raw('*,COUNT(douyu_id) as total'))->get()->toJson();
        $vote_time = DB::table('gifts')->select(DB::raw('MAX(vote_time) as end,MIN(vote_time) as start'))->where('vote_id',$lottery)->first();
//        $luck = $this->is_draw($lottery);
//        if (!$luck) {
//            return view('douyu.show', ['vote_time' => $vote_time,'vote_list' => $vote_list,'vote_id' => $lottery]);
//        } else {
//            return view('douyu.luck', ['vote_time' => $vote_time,'vote_list' => $vote_list,'luck_user' => $luck]);
//        }
        return response(['data' => $vote_list,'code' => 1]);
    }

    public function store($draw_condition = 255,Request $request) {
        $vote_id = $request->input('lottery_vote_id');
        if ($request->exists('lottery_draw_rule') && $request->input('lottery_draw_rule') !== null){
            $draw_condition = $request->input('lottery_draw_rule');
        }
        //TODO 判断vote_id是否存在以及有效性


        $gifts = DB::table('gifts')
            ->where('vote_id', (int)$vote_id)
            ->groupBy('douyu_id')
            ->havingRaw('count(douyu_id) > ' . $draw_condition)
            ->get();
        if (!$gifts->count()){
           return view('douyu.error');
        }
        $luck = [];
        foreach ($gifts as $key => $value) {
            array_push($luck, $value->douyu_id);
        }
        $result = DB::table('gifts')
            ->where('vote_id', $vote_id)
            ->whereIn('douyu_id', $luck)
            ->get();
        $arr_vote_time = [];
        $arr_douyu_id = [];
        $arr_douyu_name = [];
        foreach ($result as $k => $v) {
            array_push($arr_vote_time, (int)date('YmdHis', strtotime($v->vote_time)));
            array_push($arr_douyu_id, (int)$v->douyu_id);
            array_push($arr_douyu_name, $v->douyu_name);
        }
        $vote_time_result = array_reduce($arr_vote_time, function ($v1, $v2) {
            return $v1 + $v2;
        });
        $douyu_id_result = array_reduce($arr_douyu_id, function ($v1, $v2) {
            return $v1 + $v2;
        });
        $luckNum = ($vote_time_result + $douyu_id_result) % count($arr_douyu_id);
        $result = DB::table('lucks')->insert(['douyu_id' =>$arr_douyu_id[$luckNum],'douyu_name' => $arr_douyu_name[$luckNum],'vote_id' => $vote_id,'created_at' => date('Y-m-d H:i:s',time()) ]);
        if ($result){
            return redirect("/lottery/$vote_id");
        }else{
            return view('douyu.error');
        }
    }

    public function is_draw($vote_id) {
        $is_draw = DB::table('lucks')->where('vote_id', $vote_id)->first();
        return $is_draw;
    }
}
