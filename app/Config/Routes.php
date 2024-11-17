<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::Login');
$routes->get('/login', 'Auth::Login');
$routes->get('/pendaftaran', 'Auth::Register');
$routes->get('/home', 'HomeController::index');
$routes->get('/weather', 'WeatherController::index');