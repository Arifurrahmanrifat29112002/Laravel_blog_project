<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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
    Route::get('/create/user',[AdminUserController::class, 'create'])->name('users.create')->middleware('RoleChecker');
    Route::post('/create/user',[AdminUserController::class, 'store'])->name('users.store ')->middleware('RoleChecker');
    Route::get('/create/user_delete/{id}',[AdminUserController::class, 'destroy'])->name('users.destroy');
    //profile update
    Route::get('/admin/profile',[AdminUserController::class,'edit'])->name('profile.edit');//view edit page
    Route::post('/admin/profile/{id}',[AdminUserController::class,'update'])->name('profile.update');//profile update
    //password update
    Route::post('/admin/profile/password/{id}',[AdminUserController::class,'passwordUpdate'])->name('profile.password.update');//update user profile password update
    //resource route
    Route::resource('category',CategoryController::class);
    //delete category
    Route::post('/admin/category/delete/{id}',[CategoryController::class,'delete'])->name('category.delete')->middleware('RoleChecker');
    //parent category restore
    Route::get('/admin/category/restore/{id}',[CategoryController::class,'restore'])->name('category.restore')->middleware('RoleChecker');
    // SubCategory routes -----destroy,delete,restore
    Route::post('/admin/subcategory/destroy/{id}',[CategoryController::class,'SubDestroy'])->name('subcategory.destroy')->middleware('RoleChecker');
    //Route::post('/admin/subcategory/delete/{id}',[CategoryController::class,'SubDelete'])->name('subcategory.delete')->middleware('RoleChecker');
    Route::get('/admin/subcategory/restore/{id}',[CategoryController::class,'SubRestore'])->name('subcategory.restore')->middleware('RoleChecker');
    //resource tag route
    Route::resource('tag',TagController::class);
    //resource post route
    Route::resource('posts',PostController::class);
    Route::post('/admin/post/subCategoryList',[PostController::class,'getSubCategoryList']);
    Route::delete('/admin/post/delete/{id}',[PostController::class,'delete'])->name('post.delete');

});

require __DIR__.'/auth.php';
