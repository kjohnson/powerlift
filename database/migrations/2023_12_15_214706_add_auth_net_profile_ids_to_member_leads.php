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
        Schema::table('member_leads', function (Blueprint $table) {
            $table->text('authnet_customer_profile_id')->nullable();
            $table->text('authnet_customer_payment_profile_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_leads', function (Blueprint $table) {
            //
        });
    }
};
