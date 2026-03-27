<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

/*
|--------------------------------------------------------------------------
| Resume Analyzer Routes
|--------------------------------------------------------------------------
*/

// Upload page (home)
Route::get('/', [ResumeController::class, 'index'])
    ->name('resume.index');

Route::get('/upload', function () {
    return redirect()->route('resume.index');
});

// Handle resume upload & chatbot analysis
Route::post('/upload', [ResumeController::class, 'upload'])
    ->name('resume.upload');

// Interactive chat messages (live intent detection)
Route::post('/chat/message', [ResumeController::class, 'chatMessage'])
    ->name('chat.message');

// Save full chat transcript before PDF download
Route::post('/chat/save', [ResumeController::class, 'saveChat'])
    ->name('chat.save');

// Download PDF report
Route::post('/download-report', [ResumeController::class, 'downloadReport'])
    ->name('download.report');