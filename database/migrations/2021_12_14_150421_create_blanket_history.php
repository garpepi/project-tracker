<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlanketHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blanket_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('changes_date', $precision = 0);
            $table->foreignId('contract_history_id')->nullable()->constrained('contracts_history')->onDelete('cascade')->onUpdate('cascade');
            $table->string('desc');
            $table->integer('volume')->nullable();
            $table->foreignId('global_quantity_history_id')->nullable()->constrained('global_quantity_history')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('global_total_value_history_id')->nullable()->constrained('global_total_value_history')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('price');
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
        Schema::dropIfExists('blanket_history');
    }
}
