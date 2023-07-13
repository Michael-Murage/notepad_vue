<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', [ProfileController::class, 'returnUser']);

Route::post('notes', [NotesController::class, 'store']);

Route::get('notes', [NotesController::class, 'index']);

Route::delete('notes/{id}', [NotesController::class, 'destroy']);

Route::put('notes/{id}', [NotesController::class, 'update']);
