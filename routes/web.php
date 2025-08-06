<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtlController;
use App\Http\Controllers\OlapController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/olap', [OlapController::class, 'index'])->name('olap.analysis');
Route::post('/olap/load-analysis', [OlapController::class, 'loadAnalysis']);

Route::get('/etl', [EtlController::class, 'index'])->name('etl');
Route::post('/etl/run', [EtlController::class, 'runEtlProcess'])->name('etl.run');

Route::get('/dimensions', function () {
    return view('dimensions.index');
})->name('dimensions');

Route::get('/facts', function () {
    return view('facts.index');
})->name('facts');