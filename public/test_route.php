<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$request = \Illuminate\Http\Request::create(
    '/api/public/map-data',
    'GET',
    ['month' => '8', 'year' => '2025', 'week' => '5']
);

$response = $kernel->handle($request);
$data = json_decode($response->getContent(), true);
$laSalle = array_values(array_filter($data ?? [], fn($x) => isset($x['name']) && $x['name'] === 'La Salle'))[0] ?? null;
echo json_encode($laSalle, JSON_PRETTY_PRINT);
