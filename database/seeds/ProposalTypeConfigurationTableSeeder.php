<?php

use Illuminate\Database\Seeder;

class ProposalTypeConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('proposal_type_configurations')->delete();
        $data = [
        	['id'=>1, 'type'=>'equalization'],
        	['id'=>2, 'type'=>'new'],
        	['id'=>3, 'type'=>'extension'],
        ];
        \DB::table('proposal_type_configurations')->insert($data);
    }
}
