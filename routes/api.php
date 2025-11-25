<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

Route::post('/notes',[NotesController::class,'store'])->name('notes.store');
Route::get('/notes/{id}',[NotesController::class,'getData'])->name('notes.getData');
Route::get('/notes/{id}/render',[NotesController::class,'renderText'])->name('notes.renderText');
Route::post('/notes/{id}/check-grammer',[NotesController::class,'checkGrammer'])->name('notes.checkGrammer');
