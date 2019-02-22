<?php

$router->get('/', function () {
    app('session')->put('name', rand());

    // dd(app('session')->get('name'));
});

$router->get('/board', function () use ($router) {
    return [
        ['', '', ''],
        ['', '', ''],
        ['', '', ''],
    ];
});