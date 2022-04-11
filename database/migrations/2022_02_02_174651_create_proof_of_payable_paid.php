<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofOfPayablePaid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proof_of_payable_paid', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actual_payable_payed_id')->constrained('actual_payable_payed')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_upload');
            $table->string('filename');
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
        Schema::dropIfExists('proof_of_payable_paid');
    }
}
