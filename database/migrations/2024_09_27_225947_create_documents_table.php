<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */




    public function up(): void
    {

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title',200);
            $table->string('description', 500)->nullable();
            $table->longText('content');
            $table->unsignedBigInteger('user_id');//el usuario de creación del documento
            $table->unsignedBigInteger('relevance_id');
            $table->date('creation_date');
            $table->date('approval_date')->nullable();
            $table->date('edition_date')->nullable();
            //$table->timestamps(); Creamos nosotros estas tablas

            //----RELACIONES---
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //Relación con usuarios
            $table->foreign('relevance_id')->references('id')->on('relevance_documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
