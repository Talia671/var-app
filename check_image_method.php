<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

echo "Start\n";

try {
    $manager = new ImageManager(new Driver());
    echo "Manager created\n";
    $image = $manager->create(100, 100);
    echo "Image created\n";
    
    $methods = get_class_methods($image);
    
    // Check if 'orient' or 'orientate' exists
    $hasOrient = false;
    foreach ($methods as $m) {
        if ($m === 'orient') {
            echo "HAS_ORIENT\n";
            $hasOrient = true;
        }
        if ($m === 'orientate') {
            echo "HAS_ORIENTATE\n";
            $hasOrient = true;
        }
    }
    
    if (!$hasOrient) {
        echo "NO_ORIENT_METHOD_FOUND\n";
        // List a few methods to be sure
        echo "Sample methods: " . implode(', ', array_slice($methods, 0, 5)) . "\n";
    }
    
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
