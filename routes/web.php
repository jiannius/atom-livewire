<?php

use Jiannius\Atom\Models\Page;
use Illuminate\Support\Facades\Route;

if (!config('atom.static_site')) {
    define_route('__sitemap', 'SitemapController@index')->name('__sitemap');
    define_route('__export/{filename}', 'ExportController@download')->name('__export');

    /**
     * User Portal
     */
    Route::prefix('user')->middleware('auth')->group(function() {
        define_route('/', fn() => redirect()->route('user.authentication'))->name('user.home');
        define_route('authentication', 'User\\Authentication\\Index')->name('user.authentication');
    });

    /**
     * Onboarding Portal
     */
    if (enabled_module('signups') || enabled_module('tenants')) {
        Route::prefix('onboarding')->middleware('auth')->group(function() {
            define_route('/', 'Onboarding\\Index')->name('onboarding');
            define_route('completed', 'Onboarding\\Completed')->name('onboarding.completed');
        });
    }

    /**
     * Billing Portal
     */
    if (enabled_module('plans')) {
        Route::prefix('billing')->middleware('auth')->group(function() {
            define_route('/', 'Billing\\Index')->name('billing');
            define_route('checkout', 'Billing\\Checkout')->name('billing.checkout');
        });
    }

    /**
     * App Portal
     */
    Route::prefix('app')->middleware(['auth', 'app-guard'])->group(function() {
        define_route('/', fn() => redirect()->route('dashboard'))->name('app.home');

        /**
         * Dashboard
         */
        define_route('dashboard', 'App\\Dashboard')->name('dashboard');

        /**
         * Blogs
         */
        if (enabled_module('blogs')) {
            Route::prefix('blog')->group(function () {
                define_route('listing', 'App\\Blog\\Listing')->name('blog.listing');
                define_route('create', 'App\\Blog\\Create')->name('blog.create');
                define_route('{blog}/{tab?}', 'App\\Blog\\Update')->name('blog.update');
            });
        }

        /**
         * Enquiries
         */
        if (enabled_module('enquiries')) {
            Route::prefix('enquiry')->group(function () {
                define_route('listing',  'App\\Enquiry\\Listing')->name('enquiry.listing');
                define_route('{enquiry}', 'App\\Enquiry\\Update')->name('enquiry.update');
            });
        }

        /**
         * Tickets
         */
        if (enabled_module('tickets')) {
            Route::prefix('ticket')->group(function() {
                define_route('listing', 'App\\Ticket\\Listing')->name('ticket.listing');
                define_route('create', 'App\\Ticket\\Create')->name('ticket.create');
                define_route('{ticket}', 'App\\Ticket\\Update')->name('ticket.update');
            });
        }

        /**
         * Pages
         */
        if (enabled_module('pages')) {
            Route::prefix('page')->group(function () {
                define_route('listing',  'App\\Page\\Listing')->name('page.listing');
                define_route('{id}', 'App\\Page\\Update')->name('page.update');
            });
        }

        /**
         * Plans
         */
        if (enabled_module('plans')) {
            Route::prefix('plan')->group(function() {
                define_route('listing', 'App\\Plan\\Listing')->name('plan.listing');
                define_route('create', 'App\\Plan\\Create')->name('plan.create');
                define_route('{id}', 'App\\Plan\\Update')->name('plan.update');
            });

            Route::prefix('plan-price')->group(function() {
                define_route('create/{id}', 'App\\PlanPrice\\Create')->name('plan-price.create');
                define_route('{id}', 'App\\PlanPrice\\Update')->name('plan-price.update');
            });
        }

        /**
         * Signups
         */
        if (enabled_module('signups')) {
            Route::prefix('signup')->group(function() {
                define_route('listing', 'App\\Signup\\Listing')->name('signup.listing');
                define_route('{id}', 'App\\Signup\\Update')->name('signup.update');
            });
        }
    
        /**
         * Teams
         */
        if (enabled_module('teams')) {
            Route::prefix('team')->group(function () {
                define_route('listing', 'App\\Team\\Listing')->name('team.listing');
                define_route('create', 'App\\Team\\Create')->name('team.create');
                define_route('{id}', 'App\\Team\\Update')->name('team.update');
            });
        }
        
        /**
         * Roles
         */
        if (enabled_module('roles')) {
            Route::prefix('role')->group(function () {
                define_route('listing', 'App\\Role\\Listing')->name('role.listing');
                define_route('create', 'App\\Role\\Create')->name('role.create');
                define_route('{id}', 'App\\Role\\Update')->name('role.update');
            });
        }
    
        /**
         * Label
         */
        Route::prefix('label')->group(function () {
            define_route('listing/{type?}', 'App\\Label\\Listing')->name('label.listing');
            define_route('create/{type}', 'App\\Label\\Create')->name('label.create');
            define_route('{id}', 'App\\Label\\Update')->name('label.update');
        });
        
        /**
         * Users
         */
        Route::prefix('user')->group(function () {
            define_route('listing', 'App\\User\\Listing')->name('user.listing');
            define_route('create', 'App\\User\\Create')->name('user.create');
            define_route('{id}', 'App\\User\\Update')->name('user.update');
        });
        
        /**
         * Files
         */
        define_route('files', 'App\\File\\Listing')->name('files');
    
        /**
         * Site Settings
         */
        define_route('site-settings/{tab?}', 'App\SiteSettings\Index')->name('site-settings');
    });
}

if (enabled_module('blogs')) {
    define_route('blogs/{slug?}', 'Web\\Blog')->name('blogs');
}

define_route('contact', 'Web\\Contact')->name('contact');
define_route('contact/thank-you', 'Web\\ContactSent')->name('contact.sent');

if (enabled_module('pages') && !app()->runningInConsole()) {
    $slugs = Page::getSlugs();
    define_route('{slug}', 'Web\Page')->name('page')->where(['slug' => '(' . implode('|', $slugs) . ')']);
}

define_route('/', 'Web\\Home')->name('home');