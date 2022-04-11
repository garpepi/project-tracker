<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name_progress')->nullable();
            $table->bigInteger('payment_percentage')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('progress_status')->onDelete('cascade')->onUpdate('cascade');
            // $table->bigInteger('status_id')->nullable();
            $table->foreignId('invoice_status_id')->nullable()->constrained('progress_status')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('progress_items');
    }
}
