<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

// Registration is disabled for guests — only super users can create new users via /users/create
Route::get('register', function () {
    return redirect()->route('login');
})->name('register');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('deals/kanban', [DealController::class, 'kanban'])->name('deals.kanban');
    Route::patch('deals/{deal}/status', [DealController::class, 'updateStatus'])->name('deals.update-status');

    Route::get('contacts/kanban', [ContactController::class, 'kanban'])->name('contacts.kanban');
    Route::patch('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.update-status');

    Route::get('clients/kanban', [ClientController::class, 'kanban'])->name('clients.kanban');
    Route::patch('clients/{client}/status', [ClientController::class, 'updateStatus'])->name('clients.update-status');

    Route::resource('clients', ClientController::class);
    Route::post('clients', [ClientController::class, 'store'])->middleware('limit:max_clients')->name('clients.store');

    Route::resource('contacts', ContactController::class);
    Route::post('contacts', [ContactController::class, 'store'])->middleware('limit:max_contacts')->name('contacts.store');

    Route::resource('deals', DealController::class);
    Route::post('deals', [DealController::class, 'store'])->middleware('limit:max_deals')->name('deals.store');

    Route::resource('users', UserController::class);
    Route::post('users', [UserController::class, 'store'])->middleware('limit:max_users')->name('users.store');

    Route::get('/company-settings', [\App\Http\Controllers\CompanySettingsController::class, 'index'])->name('company-settings.index');

    Route::get('/company-info', [CompanyInfoController::class, 'show'])->name('company-info.show');

    Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');

    // Super Admin Routes
    Route::middleware(['can:manage company'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::resource('companies', \App\Http\Controllers\SuperAdmin\CompanyController::class);
        Route::post('companies/{company}/subscription', [\App\Http\Controllers\SuperAdmin\CompanyController::class, 'updateSubscription'])->name('companies.update-subscription');
        Route::resource('plans', \App\Http\Controllers\SuperAdmin\SubscriptionPlanController::class);
    });
});
