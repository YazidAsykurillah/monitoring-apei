<?php

use Illuminate\Database\Seeder;

class ProposalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('proposals')->delete();
        $data = [
        	['id'=>1, 'code'=>'P-000001', 'user_id'=>6, 'type'=>'equalization'],
        	['id'=>2, 'code'=>'P-000002', 'user_id'=>7, 'type'=>'new'],
        	['id'=>8, 'code'=>'P-000003', 'user_id'=>8, 'type'=>'extension'],
        ];

        \DB::table('proposals')->insert($data);
    }
}
