<?php
session_start();
require_once "../core/Router.php";

$router = new Router();

$router->get('', 'MainController@index');
$router->get('auth', 'AuthController@showForm');
$router->post('auth/authenticate', 'AuthController@authenticate');
$router->get('add', 'AddBookController@showForm');
$router->post('add', 'AddBookController@submitForm');
$router->get('edit', 'EditBookController@showForm');
$router->post('edit', 'EditBookController@submitForm');
$router->get('buy', 'BuyBookController@showForm');
$router->post('buy', 'BuyBookController@submitForm');
$router->get('history', 'HistoryController@index');
$router->get('register', 'RegController@showForm');
$router->post('register', 'RegController@submitForm');
$router->post('main/index', 'MainController@index');

$router->get('support', 'SupportController@showForm');
$router->post('support/submitForm', 'SupportController@submitForm');
$router->get('support/requests', 'SupportController@viewRequests');
$router->post('support/deleteRequest/{id}', 'SupportController@deleteRequest');



$router->run();
?>
