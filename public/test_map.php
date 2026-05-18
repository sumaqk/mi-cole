<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\TInstitution;

$inst = TInstitution::where('name', 'La Salle')->first();
if ($inst) {
    echo "ID: " . $inst->idInstitution . "\n";
    echo "Name: " . $inst->name . "\n";
} else {
    echo "No encontrado\n";
}
