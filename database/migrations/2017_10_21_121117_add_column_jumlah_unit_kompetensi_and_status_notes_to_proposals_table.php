<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJumlahUnitKompetensiAndStatusNotesToProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function(Blueprint $table){
            $table->integer('jumlah_unit_kompetensi')->default(0);
            $table->text('status_notes')->nullable();
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
            $table->dropColumn('jumlah_unit_kompetensi');
            $table->dropColumn('status_notes');
        });
    }
}
