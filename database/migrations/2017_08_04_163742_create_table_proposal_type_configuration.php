<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProposalTypeConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_type_configurations', function(Blueprint $table){
            $table->increments('id');
            $table->string('type')->unique();
            $table->boolean('surat_permohonan')->default(TRUE);
            $table->boolean('ktp')->default(TRUE);
            $table->boolean('foto_3x4')->default(TRUE);
            $table->boolean('ijazah')->default(TRUE);
            $table->boolean('fotokopi_sk_a_t')->default(TRUE);
            $table->boolean('surat_pernyataan')->default(TRUE);
            $table->boolean('cv')->default(TRUE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposal_type_configurations');
    }
}
