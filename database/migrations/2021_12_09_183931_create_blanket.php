<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlanket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blanket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('desc');
            $table->string('satuan');
            $table->integer('volume')->nullable();
            $table->bigInteger('price');
            $table->foreignId('global_quantity_id')->nullable()->constrained('global_quantity')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('global_total_value_id')->nullable()->constrained('global_total_value')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('blanket');
    }
}
