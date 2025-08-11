<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

Route::post('/notes',[NotesController::class,'store']);
Route::get('/notes/{id}',[NotesController::class,'getData']);
Route::get('/notes/{id}/render',[NotesController::class,'renderText']);
Route::post('/notes/{id}/check-grammer',[NotesController::class,'checkGrammer']);
