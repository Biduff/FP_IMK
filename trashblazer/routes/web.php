<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scan', [ScanController::class, 'index'])->name('scan');
Route::post('/scan/process', [ScanController::class, 'process'])->name('scan.process');
Route::get('/upload', [ScanController::class, 'upload'])->name('upload');
Route::post('/upload/process', [ScanController::class, 'uploadProcess'])->name('upload.process');
Route::delete('/upload/remove', [ScanController::class, 'removePicture'])->name('upload.remove');
