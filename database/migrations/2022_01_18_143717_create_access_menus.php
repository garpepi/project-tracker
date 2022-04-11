<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->nullable()->constrained('menus')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('access_menus');
    }
}
