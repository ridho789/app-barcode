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
        Schema::table('tbl_marking_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_marking_header')->after('id_marking_detail');
            $table->foreign('id_marking_header')->references('id_marking_header')->on('tbl_marking_headers');

            $table->unsignedBigInteger('id_customer')->nullable()->after('id_marking_header');
            $table->foreign('id_customer')->references('id_customer')->on('tbl_customers');

            $table->unsignedBigInteger('id_origin')->nullable()->after('id_customer');
            $table->foreign('id_origin')->references('id_origin')->on('tbl_origins');

            $table->unsignedBigInteger('id_unit')->nullable()->after('id_origin');
            $table->foreign('id_unit')->references('id_unit')->on('tbl_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_marking_details', function (Blueprint $table) {
            $table->dropForeign(['id_marking_header']);
            $table->dropColumn('id_marking_header');

            $table->dropForeign(['id_customer']);
            $table->dropColumn('id_customer');

            $table->dropForeign(['id_origin']);
            $table->dropColumn('id_origin');

            $table->dropForeign(['id_unit']);
            $table->dropColumn('id_unit');
        });
    }
};
