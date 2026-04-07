<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $c = new App\Http\Controllers\Admin\SentimentController();
    $result = $c->process();
    echo "Success? " . get_class($result) . "\n";
    if (method_exists($result, 'getSession')) {
        var_dump($result->getSession()->get('error'));
        var_dump($result->getSession()->get('success'));
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
