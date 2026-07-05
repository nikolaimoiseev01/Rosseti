<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = config('app.env') == ('local') ? 'admin@mail.ru' : config('admin.email');
        $password = config('app.env') == ('local') ? '12345678' : config('admin.password');
        $admin = User::create([
            'name' => 'admin',
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);

        $this->call([
            PageSeeder::class,
        ]);
    }
}
