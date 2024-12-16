<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Auth::viewLogin');
$routes->get('home', 'Auth::viewLogin');
$routes->post('auth/login', 'Auth::Login');
$routes->get('logout', 'Auth::Logout');
$routes->post('request-otp', 'Auth::requestOtp');
$routes->post('verify-otp', 'Auth::verifyOtp');
$routes->get('resend-otp', 'Auth::resendOtp');
$routes->get('pendaftaran', 'Auth::viewPendaftaran');
$routes->get('verifikasi', 'Auth::viewVerifikasi');
$routes->get('/', 'Auth::viewLogin');
$routes->get('/login', 'Auth::Login');
$routes->get('/pendaftaran', 'Auth::Register');
$routes->get('/weather', 'WeatherController::index');
$routes->post('/api/cariKode', 'WeatherController::cariKodeWilayah');
$routes->get('/api/cuaca/(:segment)', 'WeatherController::getWeatherByKodeWilayah/$1');
$routes->post('/sendNotification', 'NotificationController::sendNotification');
