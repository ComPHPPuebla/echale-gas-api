<?php
require 'resources/stations.php';

$app->get('/gas-stations', function() use ($app) {

     $stations = $app->station->retrieveAll(
         $app->request()->params(), $app->config('defaultPageSize')
     );

     $app->render('station/list.json.twig', ['stations' => $stations]);

})->name('stations');

$app->get('/gas-stations/:id', function($id) use ($app) {

    $station = $app->station->retrieveOne($id);
    $app->render('station/show.json.twig', ['station' => $station]);

})->name('station');

$app->post('/gas-stations', function() use ($app) {

    parse_str($app->request()->getBody(), $newStation);
    $station = $app->station->newStation($newStation);
    $app->render('station/show.json.twig', ['station' => $station]);

});

$app->put('/gas-stations/:id', function($id) use ($app) {

    parse_str($app->request()->getBody(), $station);
    $station = $app->station->updateStation($station, $id);
    $app->render('station/show.json.twig', ['station' => $station]);

});

$app->delete('/gas-stations/:id', function($id)  use ($app) {

    $app->station->deleteStation($id);
    $app->status(204);
});

$app->options('/gas-stations', function() use ($app) {

    $app->response()->headers->set('Allow', $app->station->getCollectionOptions());
    $app->status(200);
});

$app->options('/gas-stations/:id', function($id) use ($app) {

    $app->response()->headers->set('Allow', $app->station->getResourceOptions());
    $app->status(200);
});
