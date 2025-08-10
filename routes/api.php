<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

Route::post('/notes',[NotesController::class,'store']);
Route::get('/notes/{note}',[NotesController::class,'getData']);