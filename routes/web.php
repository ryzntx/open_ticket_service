<?php

use App\Http\Controllers\CategoriesManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FroalaHandlerController;
use App\Http\Controllers\ImageHandlerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketManagementController;
use App\Http\Controllers\TicketStatusController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localeCookieRedirect']], function () {
    Route::get('/', function () {
        return view('guests.home');
    })->name('home');

    Route::get('/ticket', [TicketController::class, 'create'])->name('ticket.create');
    Route::get('/ticket/check/{code}', [TicketController::class, 'check'])->name('ticket.check');
    Route::post('/ticket', [TicketController::class, 'store'])->name('ticket.store');

    Route::get('/ticket-check', [TicketStatusController::class, 'index'])->name('ticket.status.form');
    Route::post('/ticket-check', [TicketStatusController::class, 'check'])->name('ticket.status.check');

    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::redirect('/', '/admin/dashboard'); // Redirect to dashboard

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Dashboard and User routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User management routes
        Route::resource('users', UserManagementController::class)->middleware('isAdmin')->names('admin.users');

        // Category management routes
        Route::resource('categories', CategoriesManagementController::class)->middleware('isAdmin')->names('admin.categories');

        // Quick Reply management routes
        Route::resource('quick-replies', \App\Http\Controllers\QuickReplyController::class)->middleware('isAdmin')->names('admin.quick-replies');

        // Ticket management routes
        Route::resource('tickets', TicketManagementController::class)->names('admin.tickets');
        Route::post('tickets/{ticket}/reply', [TicketManagementController::class, 'reply'])->name('admin.tickets.reply');
        Route::post('tickets/{ticket}/change-status', [TicketManagementController::class, 'changeStatus'])->name('admin.tickets.changeStatus');

        // Artisan commands routes
    });

    Route::group(['middleware' => ['web']], function () {
        Route::get('/artisan', [\App\Http\Controllers\ArtisanController::class, 'index'])->name('artisan.index');
        Route::post('/artisan/run', [\App\Http\Controllers\ArtisanController::class, 'run'])->name('artisan.run');
    });

    require __DIR__ . '/auth.php';
});

Route::post('/froala/upload-image', [ImageHandlerController::class, 'uploadImage'])->name('froala.upload');
Route::post('/froala/delete-image', [ImageHandlerController::class, 'deleteImage'])->name('froala.delete');
Route::post('/upload-image', [ImageHandlerController::class, 'upload'])->name('upload.image');
