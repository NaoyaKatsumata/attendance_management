<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagementController;
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


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/', function () {
    //     return view('test');
    // });    
    Route::get('/', [ManagementController::class,'view']);
    Route::get('/attendance', [ManagementController::class,'viewDate']);
    Route::post('/attendance', [ManagementController::class,'search']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/update', [ManagementController::class, 'update']);
    Route::post('/store',[ManagementController::class,'store']);
    Route::post('/confirm',[ManagementController::class,'confirm']);
    Route::post('/editform',[ManagementController::class,'editform']);
    Route::post('/edit',[ManagementController::class,'edit']);
});
require __DIR__.'/auth.php';
