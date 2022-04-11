<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxProof extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_proof', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('progress_id')->constrained('progress_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tax_id')->constrained('tax')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('received')->default(0);
            $table->float('percentage')->nullable();
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
        Schema::dropIfExists('tax_proof');
    }
}
