<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function() use ($router) {
  return 'Pizza REST-API';
});

// REST-API
$router->get('/pizzas', ['uses' => 'PizzaController@index']);
$router->get('/pizzas/{id}', ['uses' => 'PizzaController@show']);
$router->post('/pizzas', ['uses' => 'PizzaController@create']);
$router->put('/pizzas/{id}', ['update', 'uses' => 'PizzaController@update']);
$router->delete('/pizzas/{id}', ['uses' => 'PizzaController@destroy']);
