<?php
// Rutas absolutas
$latestPath    = __DIR__ . "/../public/latest.json";
$locationsPath = __DIR__ . "/../public/locations.json";

// Lectura POST raw
$raw = file_get_contents("php://input");
if (!$raw) {
    http_response_code(400);
    echo json_encode(["ok"=>false,"msg"=>"no data"]);
    exit;
}
$data = json_decode($raw, true);
if (!$data || !isset($data['lat']) || !isset($data['lon'])) {
    http_response_code(400);
    echo json_encode(["ok"=>false,"msg"=>"invalid json"]);
    exit;
}

// Crear estructura de entrada
$entry = [
    "id" => isset($data['id']) ? $data['id'] : "device",
    "lat" => floatval($data['lat']),
    "lon" => floatval($data['lon']),
    "ts" => isset($data['ts']) ? intval($data['ts']) : time()
];

// Guardar latest.json
file_put_contents($latestPath, json_encode($entry));

// Guardar locations.json (máx 500 entradas)
$list = [];
if (file_exists($locationsPath)) {
    $txt = file_get_contents($locationsPath);
    $list = json_decode($txt, true);
    if (!$list) $list = [];
}
array_unshift($list, $entry);
if (count($list) > 500) $list = array_slice($list, 0, 500);
file_put_contents($locationsPath, json_encode($list));

echo json_encode(["ok"=>true,"saved"=>$entry]);
?>
