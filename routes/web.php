<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //admin options ---create a new user
    Route::get('/create/user',[AdminUserController::class, 'create'])->name('users.create');
    Route::post('/create/user',[AdminUserController::class, 'store'])->name('users.create');
    Route::get('/create/user_delete/{id}',[AdminUserController::class, 'destroy'])->name('users.destroy');
    //profile
    Route::get('/admin/profile',[AdminUserController::class,'edit'])->name('profile.edit');//view edit page
    Route::post('/admin/profile/{id}',[AdminUserController::class,'update'])->name('profile.update');//profile update
});

require __DIR__.'/auth.php';
