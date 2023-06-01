<?php

define_route('login', 'Auth\Login')->name('login');
define_route('forgot-password', 'Auth\ForgotPassword')->middleware('guest')->name('password.forgot');
define_route('reset-password', 'Auth\ResetPassword')->name('password.reset');
