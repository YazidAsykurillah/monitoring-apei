<?php

use Illuminate\Database\Seeder;

class DpdUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dpd_user')->delete();
        $data = [
            ['dpd_id'=>1, 'user_id'=>4],
        	['dpd_id'=>1, 'user_id'=>5],
        	['dpd_id'=>2, 'user_id'=>6],
            ['dpd_id'=>1, 'user_id'=>7],
        	['dpd_id'=>1, 'user_id'=>8],
        ];
        \DB::table('dpd_user')->insert($data);
    }
}
