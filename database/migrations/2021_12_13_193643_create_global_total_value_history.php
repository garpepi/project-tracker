<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalTotalValueHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_total_value_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('global_total_value_id')->constrained('global_total_value')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('total_value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_total_value_history');
    }
}
