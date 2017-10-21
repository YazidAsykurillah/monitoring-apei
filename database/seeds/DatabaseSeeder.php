<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(AclTableSeeder::class);
        $this->call(DpdTableSeeder::class);
        $this->call(DpdUserTableSeeder::class);
        $this->call(ProposalTableSeeder::class);
        $this->call(ProposalTypeConfigurationTableSeeder::class);
    }
}
