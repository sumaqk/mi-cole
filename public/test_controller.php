<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ctrl = new \App\Http\Controllers\Api\InstitutionController();
$req  = new \Illuminate\Http\Request();
$resp = $ctrl->publicMapData($req);
$data = json_decode($resp->content(), true);

$laSalle = array_values(array_filter($data, fn($x) => $x['name'] === 'La Salle'))[0] ?? null;
echo json_encode($laSalle, JSON_PRETTY_PRINT);
