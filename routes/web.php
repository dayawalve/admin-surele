<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

date_default_timezone_set('Asia/Kolkata');
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return view('clear');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [SiteController::class, 'index'])->name('dashboard');
    //profile
    Route::get('profile', [SiteController::class, 'profile'])->middleware('password.confirm')->name('profile');
    Route::patch('profile', [SiteController::class, 'update'])->name('profile.update');
    Route::patch('profile-email-change', [SiteController::class, 'updateEmail'])->name('profile.update-email');
    Route::patch('profile-password-change', [SiteController::class, 'updatePassword'])->name('profile.update-password');
    Route::patch('delete-account', [SiteController::class, 'deleteAccount'])->name('deleteAccount');
    //new
});

Route::get('send-mail',function() {
    $data['email'][0] = 'daya@aquilmedia.in';
    dispatch(new App\Jobs\SendEmailJob($data));
});