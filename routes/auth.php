<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

if (!config('atom.static_site')) {
    define_route('login', 'Auth\\Login')->name('login');
    define_route('forgot-password', 'Auth\\ForgotPassword')->middleware('guest')->name('password.forgot');
    define_route('reset-password', 'Auth\\ResetPassword')->name('password.reset');

    if (enabled_module('signups')) {
        define_route('register', 'Auth\\Register')->name('register');
        define_route('register/completed', 'Auth\\RegisterCompleted')->name('register.completed');

        if (config('atom.signups.verify')) {
            Route::middleware('auth')->group(function () {
                define_route('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
                    $request->fulfill();
                    return view('atom::auth.verify', ['action' => 'verified']);
                })->middleware('signed')->name('verification.verify');
        
                define_route('email/notify', function () {
                    request()->user()->sendEmailVerificationNotification();
                    return view('atom::auth.verify', ['action' => 'sent']);
                })->middleware('throttle:6,1')->name('verification.send');
            });
        }
    }
}
