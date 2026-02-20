<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$config = \App\Models\PaymentGatewayConfig::where('gateway_name', 'paypal')->first();
if ($config) {
    echo "API KEY (client_id): " . $config->api_key . "\n";
    echo "API SECRET: " . ($config->api_secret ? 'EXISTS' : 'NULL / EMPTY') . "\n";
    echo "ENV: " . $config->environment . "\n";
} else {
    echo "No paypal config found.\n";
}
