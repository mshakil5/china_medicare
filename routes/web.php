<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// cache clear
Route::get('/clear', function() {
  Auth::logout();
  session()->flush();
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  return "Cleared!";
});

 Route::fallback(function () {
    return redirect('/');
});

require __DIR__.'/admin.php';


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'bn'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/services', [FrontendController::class, 'services'])->name('services');
Route::get('/packages', [FrontendController::class, 'packages'])->name('packages');
Route::get('/packages-details/{slug}', [FrontendController::class, 'packages'])->name('package.details');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/store', [FrontendController::class, 'contactStore'])->name('contact.store');

Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('aboutUs');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user', 'verified']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

});