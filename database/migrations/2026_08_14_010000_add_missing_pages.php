<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing pages if they don't exist
        $missing = [
            ['slug' => 'razvitie-celoveceskogo-kapitala', 'title' => 'Развитие человеческого капитала', 'sort' => 6],
            ['slug' => 'prilozeniia', 'title' => 'Приложения', 'sort' => 9],
        ];

        foreach ($missing as $page) {
            $exists = DB::table('pages')->where('slug', $page['slug'])->exists();
            if (!$exists) {
                DB::table('pages')->insert([
                    'slug' => $page['slug'],
                    'title' => $page['title'],
                    'sort' => $page['sort'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('pages')->whereIn('slug', [
            'razvitie-celoveceskogo-kapitala',
            'prilozeniia',
        ])->delete();
    }
};
