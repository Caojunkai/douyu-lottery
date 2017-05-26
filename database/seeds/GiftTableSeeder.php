<?php
use Illuminate\Database\Seeder;
class GiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $d = ['计算机编程类','生活百科','是的','我们正','是这么计','划的','通过','与客户的接','开发FamSpam','甚至是','开发','GitHub','本身'];
        $data = [];
        for ($i=0; $i < 10000; $i++) {
            $tmp = [];
            $tmp['douyu_name'] = $d[random_int(0,12)];
            $tmp['douyu_id'] = str_random(8);
            $tmp['vote_id'] = random_int(1,4);
            $tmp['vote_time'] = date('Y-m-d H:i:s',time());
            array_push($data,$tmp);
        }
        DB::table('gifts')->insert($data);
    }
}
