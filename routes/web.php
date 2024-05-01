<?php

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', [CustomAuthController::class, 'index']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');

Route::group(['middleware' => ['auth:web']], function (){ //'as' => 'admin.' , 'prefix' => 'admin'
    Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

    Route::group(['prefix' => 'contact-us'], function()
    {
        Route::get("/", [ContactUsController::class , "index"])->name('contact-us');
        Route::get("/create", [ContactUsController::class , "create"])->name('contact-us.create');
        Route::get("/get", [ContactUsController::class , "get"])->name('edit');
        Route::get("/delete/{id}", [ContactUsController::class , "destroy"])->name('delete');
        Route::get("{id}/edit", [ContactUsController::class , "edit"])->name('get');
        Route::post("/store", [ContactUsController::class , "store"])->name('contact-us.store');

    });
    

    
});