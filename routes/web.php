<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
    ],
    function () {

        Auth::routes([
            'register' => false, // Disable registration routes
            'reset' => false,    // Disable password reset routes
            'confirm' => false,  // Disable confirm password routes
            'verify' => false,   // Disable email verification routes
        ]);


        Route::get("/", function () {
            return redirect()->route('login');
        });
        Route::get("/home", function () {
            return redirect()->route('dashboard');
        })->name('home');

        // // Define the fallback route to redirect to /not-found
        Route::fallback(function () {
            return redirect()->route('not-found'); // Use named route here
        });

        // Define the /not-found route
        Route::get('not-found', function () {
            abort(404);
        })->name('not-found'); // Name the route here;

        ## Admin routes
        require_once __DIR__ . '/admin.php';
    }
);
