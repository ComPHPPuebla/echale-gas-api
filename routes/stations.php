<?php
$app->get('/gas-station', function() use ($app) {

     $stations = $app->stationRepository->findAll();

     $app->contentType('application/json');

     echo json_encode($stations, JSON_PRETTY_PRINT);
});

$app->get('/gas-station/:id', function($id) use ($app) {

    $station = $app->stationRepository->find($id);

    echo json_encode($station, JSON_PRETTY_PRINT);
});

$app->post('/gas-station', function() use ($app) {
    parse_str($app->request()->getBody(), $newStation);

    $stationId = $app->stationRepository->insert($newStation);

    $newStation['station_id'] = $stationId;

    echo json_encode($newStation);
});

$app->put('/gas-station/:id', function($id) use ($app) {
    parse_str($app->request()->getBody(), $station);

    $app->stationRepository->update($station, $id);

    $station = $app->stationRepository->find($id);

    echo json_encode($station);
});

$app->delete('/gas-station/:id', function($id)  use ($app) {

    $app->stationRepository->delete($id);
});

$app->options('/gas-station', function() {
    echo "via OPTIONS";
});