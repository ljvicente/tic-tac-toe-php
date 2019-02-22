<?php

$router->get('/', function () {
    echo "<a href='game.html'>Click Here To Play</a>";
});

// start new game
$router->get('/start', 'GameController@start');

// get state
$router->get('/get-state', 'GameController@getBoardState');

// submit move
$router->post('/submit-move', 'GameController@submitMove');

// get status
$router->get('/get-status', 'GameController@getStatus');
