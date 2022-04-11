<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Viewable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewable', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('viewable');
    }
}
