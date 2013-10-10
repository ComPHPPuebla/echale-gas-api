<?php
require 'resources/stations.php';

$app->get('/gas-stations', function() use ($app) {

    $app->stationController->dispatch('getList', $app->resourceCollection);

})->name('stations');

$app->get('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->dispatch('get', $id, $app->resource);

})->name('station');

$app->post('/gas-stations', function() use ($app) {

    $station = $app->stationController->post($app->resource);
    $app->render('station/show.json.twig', ['station' => $station]);

});

$app->put('/gas-stations/:id', function($id) use ($app) {

    $station = $app->stationController->put($id, $app->resource);
    $app->render('station/show.json.twig', ['station' => $station]);

});

$app->delete('/gas-stations/:id', function($id)  use ($app) {

    $app->stationController->delete($id);
});

$app->options('/gas-stations', function() use ($app) {

    $app->stationController->optionsList();
});

$app->options('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->options();
});
