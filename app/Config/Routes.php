<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Auth::viewLogin');
$routes->get('home', 'HomeController::index');
$routes->post('auth/login', 'Auth::Login');
$routes->get('logout', 'Auth::Logout');
$routes->post('request-otp', 'Auth::requestOtp');
$routes->post('verify-otp', 'Auth::verifyOtp');
$routes->get('resend-otp', 'Auth::resendOtp');
$routes->get('pendaftaran', 'Auth::viewPendaftaran');
$routes->get('verifikasi', 'Auth::viewVerifikasi');