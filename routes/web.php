<?php

use App\Http\Controllers\EmployeeController;
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


Route::get('/',[EmployeeController::class,'index']);
Route::post('/store', [EmployeeController::class, 'store'])->name('store');

Route::get('/fetchall',[EmployeeController::class,'fetchemployee'])->name('fetchall');

Route::get('/edit',[EmployeeController::class,'editemployee'])->name('editemployee');

Route::post('/update',[EmployeeController::class,'updateemployee'])->name('updateemployee');

Route::post('/delete',[EmployeeController::class,'deleteemployee'])->name('deleteemployee');