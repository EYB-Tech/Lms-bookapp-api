<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubscriptionController;

Route::group(['middleware' => ['auth', 'checkUserType:Admin',]], function () {
    Route::get('/cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');

        return back();
    })->name('cache');

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
        Route::resource('tags', TagController::class);
        Route::resource('courses', CourseController::class);

        Route::get('/fetch-uploads', [UploadController::class, 'fetch_uploads'])->name('fetch-uploads');
        Route::resource('uploads', UploadController::class);
        Route::get('/files/stream/{upload}', [UploadController::class, 'streamFile'])->name('files.stream');
        Route::controller(LessonController::class)->group(function () {
            // Route::get('/lessons', 'index')->name('lessons.index');
            Route::get('/lessons/content/get', 'content')->name('lessons.content');
            Route::get('/courses/{course}/lessons/create', 'create')->name('lessons.create');
            Route::post('/courses/{course}/lessons', 'store')->name('lessons.store');
            Route::get('/lessons/{lesson}', 'show')->name('lessons.show');
            Route::get('/lessons/{lesson}/edit', 'edit')->name('lessons.edit');
            Route::put('/lessons/{lesson}/update', 'update')->name('lessons.update');
            Route::delete('/lessons/{lesson}', 'destroy')->name('lessons.destroy');
        });
        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('/subscriptions', 'index')->name('subscriptions.index');
            Route::post('/subscriptions', 'store')->name('subscriptions.store');
            Route::get('/subscriptions/create', 'create')->name('subscriptions.create');
            Route::get('/subscriptions/{subscription}', 'show')->name('subscriptions.show');
            Route::put('/subscriptions/{subscription}/update', 'update')->name('subscriptions.update');
            Route::delete('/subscriptions/{subscription}', 'destroy')->name('subscriptions.destroy');
            Route::post('/subscriptions/import-students', 'importStudents')->name('subscriptions.import-students');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/{user}/impersonate', 'startImpersonation')->name('users.impersonate');
                Route::put('/{user}/change-password', 'changePassword')->name('users.change-password');
                Route::put('/{user}/update-permissions', 'updatePermissions')->name('users.update-permissions');
                Route::delete('/{user}', 'destroy')->name('users.destroy');
            });
            Route::controller(StaffController::class)->group(function () {
                Route::get('/staffs', 'index')->name('staffs.index');
                Route::get('/staffs/create', 'create')->name('staffs.create');
                Route::post('/staffs', 'store')->name('staffs.store');
                Route::get('/staffs/{user}', 'show')->name('staffs.show');
                Route::get('/staffs/{user}/edit', 'edit')->name('staffs.edit');
                Route::put('/staffs/{user}/update', 'update')->name('staffs.update');
            });
            Route::controller(StudentController::class)->group(function () {
                Route::get('/students', 'index')->name('students.index');
                Route::get('/students/create', 'create')->name('students.create');
                Route::post('/students', 'store')->name('students.store');
                Route::post('/students/import', 'import')->name('students.import');
                Route::get('/students/{student}', 'show')->name('students.show');
                Route::get('/students/{student}/edit', 'edit')->name('students.edit');
                Route::get('/students/export/example', 'exportExample')->name('students.export-example');
                Route::put('/students/{student}/update', 'update')->name('students.update');
                Route::delete('/students/{user}', 'destroy')->name('students.destroy');
                Route::delete('/students/bulk/delete', 'bulkDelete')->name('students.bulk-delete');
            });
        });
        Route::controller(LanguageController::class)->group(function () {
            Route::get('/languages', 'index')->name('languages.index');
            Route::post('/languages', 'store')->name('languages.store');
            Route::post('/languages/add-new-words', 'addNewWords')->name('languages.add-new-words');
            Route::get('/languages/{language}/search', 'searchWords')->name('languages.search-words');
            Route::get('/languages/{language}', 'show')->name('languages.show');
            Route::put('/languages/{language}', 'update')->name('languages.update');
            Route::put('/languages/{language}/update-words', 'updateWords')->name('languages.update-words');
            Route::put('/languages/{language}/make-default', 'make_default')->name('languages.make-default');
            Route::delete('/languages/{language}', 'destroy')->name('languages.destroy');
        });
        Route::group(['prefix' => 'website-setup'], function () {
            Route::controller(SettingController::class)->group(function () {
                Route::get('/basic-settings', 'basic_settings')->name('settings.basic');
                Route::get('/auth-layout-settings', 'auth_layout_settings')->name('settings.auth-layout');
                Route::get('/footer-settings', 'footer_settings')->name('settings.footer');
                Route::post('/update', 'update')->name('settings.update');
            });
        });
    });
});
