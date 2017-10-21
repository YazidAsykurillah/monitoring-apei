<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUncompleteDescriptionAndReceivedDateToTableProposals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function(Blueprint $table){
            $table->text('uncomplete_reason')->nullable();
            $table->date('received_date')->nullable();
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
            $table->dropColumn('uncomplete_reason');
            $table->dropColumn('received_date');
        });
    }
}
