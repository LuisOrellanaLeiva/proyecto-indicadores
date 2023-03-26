<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\IndicatorController;

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

Route::get('/',[IndicatorController::class,'index'])->name('indicators.index');
Route::post('/store',[IndicatorController::class,'store'])->name('indicators.store');
Route::post('/getGraphValues', [IndicatorController::class, 'getGraphValues'])->name('indicators.graph.values');
Route::get('/getIndicators',[IndicatorController::class , 'getIndicators'])->name('indicators.getIndicators');
Route::get('/edit', [IndicatorController::class, 'edit'])->name('indicators.edit');
Route::post('/edit',[IndicatorController::class,'edit'])->name('indicators.edit');
Route::post('/update', [IndicatorController::class, 'update'])->name('indicators.update');
Route::post('/destroy', [IndicatorController::class, 'destroy'])->name('indicators.destroy');



