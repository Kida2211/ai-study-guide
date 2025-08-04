<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyGuideController;

Route::get('/', [StudyGuideController::class, 'index']);
Route::post('/generate', [StudyGuideController::class, 'generate'])->name('study.generate');

