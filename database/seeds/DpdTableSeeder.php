<?php

use Illuminate\Database\Seeder;

class DpdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dpds')->delete();

        $data = [
        	['id'=>1,'code'=>'DPD-01', 'name'=>'JAWA BARAT'],
        	['id'=>2,'code'=>'DPD-02', 'name'=>'JAWA TENGAH'],
            ['id'=>3,'code'=>'DPD-03', 'name'=>'DAERAH ISTIMEWA YOGYAKARTA'],
            ['id'=>4,'code'=>'DPD-04', 'name'=>'JAWA TIMUR'],
            ['id'=>5,'code'=>'DPD-05', 'name'=>'BALI'],
            ['id'=>6,'code'=>'DPD-06', 'name'=>'NUSA TENGGARA BARAT'],
            ['id'=>7,'code'=>'DPD-07', 'name'=>'NUSA TENGGARA TIMUR'],
            ['id'=>8,'code'=>'DPD-08', 'name'=>'PAPUA'],
            ['id'=>9,'code'=>'DPD-09', 'name'=>'MALUKU UTARA'],
        	['id'=>10,'code'=>'DPD-10', 'name'=>'MALUKU'],
        ];

        \DB::table('dpds')->insert($data);
    }
}
