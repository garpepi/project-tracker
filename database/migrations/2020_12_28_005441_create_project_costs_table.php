<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progress_item_id')->nullable()->constrained('progress_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('suplier_id')->constrained('suplier')->onDelete('cascade')->onUpdate('cascade');
            $table->string('desc')->nullable();
            $table->bigInteger('budget_of_quantity')->nullable();
            $table->boolean('payed')->default(0);
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
        Schema::dropIfExists('project_costs');
    }
}
