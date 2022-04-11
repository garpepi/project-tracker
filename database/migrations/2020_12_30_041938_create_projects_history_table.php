<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('changes_date', $precision = 0);
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('edit_by')->nullable();
            // $table->bigInteger('contract_id')->nullable();
            $table->string('name');
            $table->bigInteger('no_po')->nullable();
            $table->date('po_sign_date')->nullable();
            $table->date('po_start_date')->nullable();
            $table->date('po_end_date')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('volume_use')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('projects_history');
    }
}
