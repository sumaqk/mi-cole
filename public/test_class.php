<?php
require __DIR__.'/../vendor/autoload.php';
$ref = new ReflectionClass(\App\Http\Controllers\Api\InstitutionController::class);
echo $ref->getFileName() . "\n";
$method = $ref->getMethod('buildMapData');
echo "buildMapData at line: " . $method->getStartLine() . "\n";
$source = file($ref->getFileName());
echo implode('', array_slice($source, $method->getStartLine() + 18, 5));
