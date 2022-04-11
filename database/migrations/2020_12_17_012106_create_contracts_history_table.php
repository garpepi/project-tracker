<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('changes_date', $precision = 0);
            $table->foreignId('cont_id')->constrained('contracts')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('edit_by')->nullable();
            $table->string('name')->nullable();
            $table->string('cont_num')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('volume')->nullable();
            $table->string('unit')->nullable();
            $table->bigInteger('price')->nullable();
            $table->date('sign_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('type_id')->nullable();
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
        Schema::dropIfExists('contracts_history');
    }
}
