<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Auth::Login');
$routes->get('/pendaftaran', 'Auth::Register');
