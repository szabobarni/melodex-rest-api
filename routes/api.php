<<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

Route::post('/user/login', [UserController::class, 'login']); 
Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');

Route::get('/artist', [ArtistController::class, 'index']);
Route::post('/artist', [ArtistController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/artist/{id}', [ArtistController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/artist/{id}', [ArtistController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/member', [MemberController::class, 'index']);
Route::post('/member', [MemberController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/member/{id}', [MemberController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/member/{id}', [MemberController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/album', [AlbumController::class, 'index']);
Route::post('/album', [AlbumController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/album/{id}', [AlbumController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/album/{id}', [AlbumController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/song', [SongController::class, 'index']);
Route::post('/song', [SongController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/song/{id}', [SongController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/song/{id}', [SongController::class, 'destroy'])->middleware('auth:sanctum');