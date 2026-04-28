<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('home_contents')->update([
            'delivery_points' => json_encode([
                'Nairobi pickup available',
                'Nationwide delivery',
                'Pay via Till Buy Goods 8541600',
            ], JSON_UNESCAPED_UNICODE),
            'consult_secondary_link' => 'https://wa.me/254113838291',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('home_contents')->update([
            'delivery_points' => json_encode([
                'Nairobi pickup available',
                'Nationwide delivery',
                '7-day returns',
            ], JSON_UNESCAPED_UNICODE),
            'consult_secondary_link' => 'https://wa.me/254707396751',
            'updated_at' => now(),
        ]);
    }
};
