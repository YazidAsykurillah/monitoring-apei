<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProposalFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_files', function(Blueprint $table){
            $table->increments('id');
            $table->integer('proposal_id');
            $table->enum('file',[
                'surat_permohonan', 'ktp','foto_3x4', 'ijazah', 
                'fotokopi_sk_a_t','surat_pernyataan', 'cv'
            ])->nullable();
            $table->boolean('status')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposal_files');
    }
}
