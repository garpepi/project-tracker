<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxProjectCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_project_cost', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_cost_id')->constrained('project_costs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tax_id')->nullable()->constrained('tax')->onDelete('cascade')->onUpdate('cascade');
            $table->float('percentage')->nullable();
            $table->bigInteger('create_by');
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
        Schema::dropIfExists('tax_project_cost');
    }
}
