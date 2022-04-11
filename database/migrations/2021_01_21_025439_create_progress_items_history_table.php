<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressItemsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_items_history', function (Blueprint $table) {
            $table->id();
            $table->timestamp('changes_date', $precision = 0);
            $table->foreignId('progress_item_id')->constrained('progress_items')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('project_id')->nullable();
            $table->string('name_progress')->nullable();
            $table->bigInteger('payment_percentage')->nullable();
            $table->bigInteger('status_id')->nullable();
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
        Schema::dropIfExists('progress_items_history');
    }
}
