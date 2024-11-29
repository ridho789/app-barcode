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
        Schema::create('tbl_marking_headers', function (Blueprint $table) {
            $table->id('id_marking_header');
            $table->string('outer_marking');
            $table->date('date');
            $table->string('via')->nullable();
            $table->string('vessel_sin')->nullable();
            $table->string('qty_koli')->nullable();
            $table->string('note')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->integer('printcount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_marking_headers');
    }
};
