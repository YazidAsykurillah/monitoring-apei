<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusDjkToProposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function(Blueprint $table){
            $table->enum('status_djk', ['proses', 'diterima', 'ditolak', 'draft', 'agenda', 'input_hasil', 'selesai'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function(Blueprint $table){
             $table->dropColumn('status_djk');
        });
    }
}
