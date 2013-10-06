<?php
$app->get('/gas-station', function() use ($app) {
     $connection = $app->connection;

     $statement = $connection->prepare('SELECT * FROM stations');
     $statement->execute();
     $stations = $statement->fetchAll();

     echo json_encode($stations, JSON_PRETTY_PRINT);
});
// /gas-station/1/comments/2
// /gas-station/1/
$app->get('/gas-station/:id', function($id) {
 echo 'via GET with id = ' . $id;
});

$app->post('/gas-station/:id', function($id) {
    echo 'Isaac';
});

$app->put('/gas-station/:id', function($id) {
    echo "via PUT with id = $id";
});

$app->delete('/gas-station/:id', function($id) {
    echo "via DELETE with id = $id";
});

$app->options('/gas-station', function() {
    echo "via OPTIONS";
});