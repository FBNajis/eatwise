<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/signup', function () {
    return view('signup');
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
Route::get('/otp', function () {
    return view('otp');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/sidebar', function () {
    return view('sidebar');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/chatbot', function () {
    return view('chatbot');
});
Route::get('/recipe', function () {
    return view('recipe');
});
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/recipe', function () {
    return view('recipe');
})->name('recipe');

Route::get('/chatbot', function () {
    return view('chatbot');
})->name('chatbot');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/sidebar', function () {
    return view('sidebar');
});
Route::get('/detailrecipe', function () {
    return view('detailrecipe');
});
