<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo 'Total blocks: ' . \App\Models\Block::count() . PHP_EOL;
echo 'Types: ' . implode(', ', \App\Models\Block::pluck('type')->unique()->toArray()) . PHP_EOL;
