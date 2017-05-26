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
        $d = ['计算机编程类','这是最好的时代','这是最坏的时代','这是智慧的时代','这是愚蠢的时代','这是信仰的时期','这是怀疑的时期','这是光明的季节','这是黑暗的季节','这是希望之春','这是失望之冬','GitHub','们面前有着各样事物','人们面前一无所有','人们正在直登天堂','人们正在直下地狱'];
        $data = [];
        for ($i=0; $i < 20000; $i++) {
            $tmp = [];
            $tmp['douyu_name'] = $d[random_int(0,count($d)-1)];
            $tmp['douyu_id'] = str_random(8);
            $tmp['vote_id'] = random_int(1,4);
            $tmp['vote_time'] = date('Y-m-d H:i:s',time());
            array_push($data,$tmp);
        }
        DB::table('gifts')->insert($data);
    }
}
