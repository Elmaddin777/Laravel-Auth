<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
  Route::get('/', 'back\HomeController@index')->name('home');
  Route::get('/logout', 'back\LoginController@logout')->name('logout');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', 'back\LoginController@index')->name('login.index');
  Route::post('/login', 'back\LoginController@login')->name('login.post');

  Route::get('/register', 'back\RegisterController@index')->name('register.index');
  Route::post('/register', 'back\RegisterController@register')->name('register.post');
  Route::get('/user/verify/{token}', 'back\RegisterController@verifyUser')->name('user.verify');

  Route::get('/reset', 'back\PasswordResetController@index')->name('reset.index');
  Route::post('/reset/post', 'back\PasswordResetController@resetPost')->name('reset.post');
  Route::get('/reset/password/{token}', 'back\PasswordResetController@resetPassword')->name('reset');

  
  Route::get('/recover/password/{token}', 'back\PasswordResetController@recoverPassword')->name('recover');
  Route::post('/recover/post', 'back\PasswordResetController@recoverPasswordPost')->name('recover.post');
});

