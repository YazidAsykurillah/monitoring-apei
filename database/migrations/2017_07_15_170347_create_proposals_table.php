<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('Auto and unique number, needed by the system');
            $table->integer('user_id')->comment('Member that own this proposal');
            $table->enum('type', ['equalization', 'new', 'extension'])->nullable()->default(NULL);
            $table->string('surat_permohonan')->nullable();
            $table->string('ktp')->nullable();
            $table->string('foto_3x4')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('fotokopi_sk_a_t')->nullable();
            $table->string('surat_pernyataan')->nullable();
            $table->string('cv')->nullable();
            $table->enum('status',[
                '0','1','2','3','4','5','6','7','8','9', '10'
            ])->default('0');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposals');
    }
}
