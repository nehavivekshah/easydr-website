<?php

use App\Models\Video_call_gateway_configs;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$configs = Video_call_gateway_configs::all();

if ($configs->isEmpty()) {
    echo "No video call gateway configurations found.\n";
} else {
    foreach ($configs as $config) {
        echo "ID: " . $config->id . "\n";
        echo "Provider: " . $config->provider_name . "\n";
        echo "App ID: " . $config->app_id . "\n";
        echo "Environment: " . $config->environment . "\n";
        echo "Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
        echo "--------------------------------------------------\n";
    }
}
