<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vote_time = DB::table('gifts')->select('gifts.vote_id', DB::raw('MAX(gifts.vote_time) as end_time,MIN(gifts.vote_time) as start_time'))->groupBy('gifts.vote_id')->orderBy('start_time', 'desc')->paginate();
        $luckier = DB::table('lucks')->pluck('vote_id')->toArray();
        foreach ($vote_time->items() as $k => $v){
            if (in_array($v->vote_id,$luckier)){
                $v->douyu_id = 1;
            }else{
                $v->douyu_id = 0;
            }
        }
        return view('douyu.lottery', ['vote_times' => $vote_time]);
    }

    public function show($lottery)
    {
        $luckier = DB::table('lucks')->where('vote_id','=',$lottery)->first();
        if ($luckier){
            return view('douyu.show',['vote_id' => $lottery,'luckier' => $luckier]);
        }
        return view('douyu.draw', ['vote_id' => $lottery]);
    }

    public function store($draw_condition = 255, Request $request, $page = 1)
    {
        $vote_id = $request->input('lottery_vote_id');
        if ($request->exists('lottery_draw_rule') && $request->input('lottery_draw_rule') !== null) {
            $draw_condition = $request->input('lottery_draw_rule');
        }
        //TODO 判断vote_id是否存在以及有效性

    }

    public function is_draw($vote_id)
    {
        $is_draw = DB::table('lucks')->where('vote_id', $vote_id)->first();
        return $is_draw;
    }

    /**
     * @param int                      $draw_condition
     * @param \Illuminate\Http\Request $request
     * @desc 抽奖函数
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */

    public function draw($draw_condition = 255, Request $request)
    {
        $vote_id = $request->input('lottery_vote_id');
        if ($request->exists('lottery_draw_rule') && $request->input('lottery_draw_rule') !== null) {
            $draw_condition = $request->input('lottery_draw_rule');
        }
        //TODO 判断vote_id是否存在以及有效性

        $gifts = DB::select("SELECT x.douyu_id,x.douyu_name,x.vote_time FROM (SELECT `id`,`vote_time`,`douyu_name`,@num := if(@group = `douyu_id`,@num + 1,1) AS row_number,@group := `douyu_id` AS douyu_id	 FROM (SELECT `id`,`douyu_id`,`douyu_name`,`vote_time`,`vote_id` FROM gifts ORDER BY `douyu_id`) AS a WHERE `vote_id` = :vote_id) AS x WHERE x.row_number <= :rule", [':vote_id' => $vote_id, ':rule' => $draw_condition]);
        if (!count($gifts)) {
            return view('douyu.error');
        }
        $vote_time_result = 0;
        $vote_uid_result = 0;
        foreach ($gifts as $k => $v) {
            $vote_time_result +=  (int)date('YmdHis', strtotime($v->vote_time));
            $vote_uid_result += (int)$v->douyu_id;
        }
        $luckNum =(($vote_time_result + $vote_uid_result) % count($gifts) + 1) % count($gifts);
        $luckier = $gifts[$luckNum];
        $luckier->vote_id = $vote_id;
        $save_luckier = DB::table('lucks')->insert((array)$luckier);
        sleep(4);
        if ($save_luckier) {
            return response(['msg'=>$luckier,'code'=>1]);
        }
        return response(['msg' =>'抽取失败','code'=>0]);
    }

//获取全部礼物记录
    public function getAllGifts($id)
    {
        $gifts = DB::table('gifts')->where('vote_id', '=', $id)->paginate(1000)->toJson();
        return response(['msg' => $gifts,'code' => 1]);
    }

//获取筛选后的数据
    public function getCleanGifts($id, Request $request)
    {
        $page = abs((int)$request->input('page'));
        if (!$page) {
            $page = 1;
        }
        $gifts = DB::select("SELECT x.id,x.douyu_name,x.vote_time FROM (SELECT `id`,`vote_time`,`douyu_name`,@num := if(@group = `douyu_id`,@num + 1,1) AS row_number,@group := `douyu_id` AS douyu_id	FROM (SELECT `id`,`douyu_id`,`douyu_name`,`vote_time`,`vote_id` FROM gifts ORDER BY `douyu_id`) AS a WHERE `vote_id` = :vote_id) AS x WHERE x.row_number <= :rule LIMIT :offset,:rows", [':vote_id' => $id, ':rule' => 255, ':offset' => ($page - 1) * 1000, ':rows' => 1000]);
        return response(['msg' => json_encode($gifts),'code' => 1]);
    }
}
