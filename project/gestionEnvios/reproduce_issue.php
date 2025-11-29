<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = new \App\Models\User();

echo "User class: " . get_class($user) . "\n";
echo "Has hasRole method: " . (method_exists($user, 'hasRole') ? 'Yes' : 'No') . "\n";

if (method_exists($user, 'hasRole')) {
    try {
        $user->hasRole('admin');
        echo "Called hasRole('admin') successfully.\n";
    } catch (\Exception $e) {
        echo "Error calling hasRole: " . $e->getMessage() . "\n";
    }
} else {
    echo "Traits used: \n";
    print_r(class_uses($user));
}
