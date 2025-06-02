<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/forgotpassword_fillemail', function () {
    return view('forgotpassword_fillemail');
});
Route::get('/forgotpassword_fillotp', function () {
    return view('forgotpassword_fillotp');
});
Route::get('/forgotpassword_fillpassword', function () {
    return view('forgotpassword_fillpassword');
});
