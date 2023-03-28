<?php

global $router;

$router->get('/comments', 'CommentController@index');
$router->post('/comment', 'CommentController@store');