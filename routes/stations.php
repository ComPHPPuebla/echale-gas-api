<?php
require 'resources/stations.php';

$app->get('/gas-stations', function() use ($app) {

    $app->stationController->dispatch('getList', [$app->resourceCollection]);

})->name('stations');

$app->get('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->dispatch('get', [$id, $app->resource]);

})->name('station');

$app->post('/gas-stations', function() use ($app) {

    $app->stationController->dispatch('post', [$app->resource, $app->stationValidator]);

});

$app->put('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->dispatch('put', [$id, $app->resource]);

});

$app->delete('/gas-stations/:id', function($id)  use ($app) {

    $app->stationController->dispatch('delete', [$id]);

});

$app->options('/gas-stations', function() use ($app) {

    $app->stationController->dispatch('optionsList', []);

});

$app->options('/gas-stations/:id', function($id) use ($app) {

    $app->stationController->dispatch('options', []);

});
