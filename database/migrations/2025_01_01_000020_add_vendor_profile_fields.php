<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vendor_profiles', function (Blueprint $table) {
            $table->decimal('balance', 12, 2)->default(0)->after('logo_path');
            $table->json('payout_info')->nullable()->after('balance');
            $table->json('documents')->nullable()->after('payout_info');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_profiles', function (Blueprint $table) {
            $table->dropColumn(['balance', 'payout_info', 'documents']);
        });
    }
};
