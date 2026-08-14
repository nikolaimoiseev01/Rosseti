<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix wrong title: razvitie-celoveceskogo-kapitala had "Защита прав человека" instead of its own title
        DB::table('pages')
            ->where('slug', 'razvitie-celoveceskogo-kapitala')
            ->update(['title' => 'Развитие человеческого капитала']);

        // Fix null title for zashhita-prav-celoveka
        DB::table('pages')
            ->where('slug', 'zashhita-prav-celoveka')
            ->update(['title' => 'Защита прав человека']);

        // Fix null title for prilozeniia
        DB::table('pages')
            ->where('slug', 'prilozeniia')
            ->update(['title' => 'Приложения']);
    }

    public function down(): void
    {
        // no rollback needed
    }
};
