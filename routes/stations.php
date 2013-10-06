<?php
require '../resources/stations.php';

$app->get('/gas-stations', function() use ($app) {

     $stations = $app->stationRepository->findAll();

     $app->contentType('application/json');

     echo json_encode($stations, JSON_PRETTY_PRINT);
});

$app->get('/gas-stations/:id', function($id) use ($app) {

    $station = $app->stationRepository->find($id);

    echo json_encode($station, JSON_PRETTY_PRINT);
});

$app->post('/gas-stations', function() use ($app) {
    parse_str($app->request()->getBody(), $newStation);

    $stationId = $app->stationRepository->insert($newStation);

    $newStation['station_id'] = $stationId;

    echo json_encode($newStation);
});

$app->put('/gas-stations/:id', function($id) use ($app) {
    parse_str($app->request()->getBody(), $station);

    $app->stationRepository->update($station, $id);

    $station = $app->stationRepository->find($id);

    echo json_encode($station);
});

$app->delete('/gas-stations/:id', function($id)  use ($app) {

    $app->stationRepository->delete($id);
});

$app->options('/gas-stations', function() {
    echo "via OPTIONS";
});