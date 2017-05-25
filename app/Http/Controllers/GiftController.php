<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GiftController extends Controller{
    public function __construct()
    {
        $this->middleware('douyu.post');
    }
    public function insert(Request $request){
        $rules = [
            'data' => 'required|json'
        ];
        $this->validate($request,$rules);
        $data = $request->input('data');
        $data_arr = json_decode($data,true);
        try {
            DB::transaction(function () use ($data_arr) {
                DB::table('gifts')->insert($data_arr);
            });
        } catch (\Exception $e) {
            return response([
                'msg' => 'data error',
                'code' => -1
            ]);
        }
        return response([
            'msg' => 'success',
            'code' => 200
        ]);
    }
}
