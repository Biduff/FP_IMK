<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\TipsnTricksController;
use App\Http\Controllers\AdminController;

// Existing routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scan', [ScanController::class, 'index'])->name('scan');
Route::post('/scan/process', [ScanController::class, 'process'])->name('scan.process');
Route::get('/upload', [ScanController::class, 'upload'])->name('upload');
Route::post('/upload/process', [ScanController::class, 'uploadProcess'])->name('upload.process');
Route::delete('/upload/remove', [ScanController::class, 'removePicture'])->name('upload.remove');
Route::post('/upload/new', [ScanController::class, 'startNewUpload'])->name('upload.new');

// Tips & Tricks routes
Route::get('/tipsntricks', [TipsnTricksController::class, 'index'])->name('tipsntricks.index');
Route::get('/tipsntricks/{id}', [TipsnTricksController::class, 'show'])->name('tipsntricks.show');

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/tipsntricks', [AdminController::class, 'store'])->name('admin.store');
Route::put('/admin/tipsntricks/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/tipsntricks/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');