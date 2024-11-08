<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\AddUserToView;
use App\Http\Middleware\AdminRedirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\SittingRequestController;

Route::get('/', function () {return view('home');})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', AddUserToView::class, AdminRedirect::class])->name('dashboard');

// house routes
Route::middleware('auth')->group(function () {
    Route::get('/houses/create', [HouseController::class, 'create'])->name('houses.create');
    Route::post('/houses/store', [HouseController::class, 'store'])->name('houses.store');
    Route::get('/houses/{house}', [HouseController::class, 'edit'])->name('houses.edit');
    Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
    Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');
    Route::delete('/housePhoto/{housePhoto}', [HouseController::class, 'deletePhoto'])->name('houses.deletePhoto');
});

//pet routes
Route::middleware('auth')->group(function(){
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::get('/pets/overview', [PetController::class, 'index'])->name('pets.index');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/pets/{pet}', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    Route::delete('/petPhoto/{petPhoto}', [PetController::class, 'deletePhoto'])->name('pets.deletePhoto');
});

//sittingRequest routes
Route::middleware('auth')->group(function () {
    Route::get('/sittingRequests', [SittingRequestController::class, 'index'])->name('sittingrequests.index');
    Route::get('/sittingRequests/create/', [SittingRequestController::class, 'create'])->name('sittingrequests.create');
    Route::get('/sittingRequests/{sittingRequest}', [SittingRequestController::class, 'show'])->name('sittingrequests.show');
    Route::post('/sittingRequests', [SittingRequestController::class, 'store'])->name('sittingrequests.store');
    Route::get('/sittingRequests/{sittingRequest}/edit', [SittingRequestController::class, 'edit'])->name('sittingrequests.edit');
    Route::put('/sittingRequests/{sittingRequest}', [SittingRequestController::class, 'update'])->name('sittingrequests.update');
    Route::delete('/sittingRequests/{sittingRequest}', [SittingRequestController::class, 'destroy'])->name('sittingrequests.destroy');
});

//application routes
Route::middleware('auth')->group(function () {
    Route::get('/application', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/application/apply', [ApplicationController::class, 'apply'])->name('applications.apply');
    Route::get('/application/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/application/{application}', [ApplicationController::class, 'update'])->name('applications.update');
});

//review routes
Route::middleware('auth')->group(function () {
    Route::get('/review/create/{application}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
});

// profile routes
Route::middleware('auth')->group(function () {
    Route::get('/user', [ProfileController::class, 'edit'])->name('user.edit');
    Route::put('/user', [ProfileController::class, 'update'])->name('user.update');
    Route::delete('/user', [ProfileController::class, 'destroy'])->name('user.destroy');
    Route::get('/profile', [ProfileController::class, 'profileEdit'])->name('profile.edit');
    Route::put('/profile/{profile}', [ProfileController::class, 'profileUpdate'])->name('profile.updater');
    Route::put('/profile', [ProfileController::class, 'photoUpdate'])->name('profile.photo');
});

// admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/block-user/{user}', [AdminController::class, 'blockUser'])->name('admin.blockUser');
    Route::put('/admin/unblock-user/{user}', [AdminController::class, 'unblockUser'])->name('admin.unblockUser');
    Route::delete('/admin/delete-request/{sittingRequest}', [AdminController::class, 'deleteRequest'])->name('admin.deleteRequest');
});

require __DIR__.'/auth.php';
