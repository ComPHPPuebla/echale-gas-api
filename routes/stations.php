<?php
require 'resources/stations.php';

$app->get('/gas-stations', function() use ($app) {

    $app->stationController->getList();

})->name('stations');

$app->get('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->get($id);

})->name('station');

$app->post('/gas-stations', function() use ($app) {

    $app->stationController->post();

});

$app->put('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->put($id);

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
