<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualPayablePayed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_payable_payed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_cost_id')->constrained('project_costs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('amount');
            $table->bigInteger('create_by');
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('actual_payable_payed');
    }
}
