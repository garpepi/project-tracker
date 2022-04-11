<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCostsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_costs_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('changes_date', $precision = 0);
            $table->foreignId('project_cost_id')->constrained('project_costs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('progress_item_id')->nullable()->constrained('progress_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('suplier_id')->constrained('suplier')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('project_id')->nullable();
            $table->string('desc')->nullable();
            $table->bigInteger('budget_of_quantity')->nullable();
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
        Schema::dropIfExists('project_costs_history');
    }
}
