<<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

//--Artist--
Route::get('/artists', [ArtistController::class, 'index']);
Route::get('/artist/{id}', [ArtistController::class, 'show']);
Route::post('/artist', [ArtistController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/artist/{id}', [ArtistController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/artist/{id}', [ArtistController::class, 'destroy'])->middleware('auth:sanctum');
//--Artist/Member--
Route::get('/artist/{id}/members', [ArtistController::class, 'index_member']);
Route::post('/artist/{id}/member', [ArtistController::class, 'store_member'])->middleware('auth:sanctum');
Route::patch('/artist/{artist_id}/member/{id}', [ArtistController::class, 'update_member'])->middleware('auth:sanctum');
Route::delete('/artist/{artist_id}/member/{id}', [ArtistController::class, 'destroy_member'])->middleware('auth:sanctum');
//--Artist/Album--
Route::get('/artist/{id}/albums', [ArtistController::class, 'index_album']);
Route::post('/artist/{id}/album', [ArtistController::class, 'store_album'])->middleware('auth:sanctum');
Route::patch('/artist/{artist_id}/album/{id}', [ArtistController::class, 'update_album'])->middleware('auth:sanctum');
Route::delete('/artist/{artist_id}/album/{id}', [ArtistController::class, 'destroy_album'])->middleware('auth:sanctum');
//--Artist/Album/Song--
Route::get('/artist/{artist_id}/album/{id}/songs', [ArtistController::class, 'index_song']);
Route::post('/artist/{artist_id}/album/{id}/song', [ArtistController::class, 'store_song'])->middleware('auth:sanctum');
Route::patch('/artist/{artist_id}/album/{album_id}/song/{id}', [ArtistController::class, 'update_song'])->middleware('auth:sanctum');
Route::delete('/artist/{artist_id}/album/{album_id}/song/{id}', [ArtistController::class, 'destroy_song'])->middleware('auth:sanctum');
//--Member--
Route::get('/members', [MemberController::class, 'index']);
Route::post('/member', [MemberController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/member/{id}', [MemberController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/member/{id}', [MemberController::class, 'destroy'])->middleware('auth:sanctum');
//--Album--
Route::get('/albums', [AlbumController::class, 'index']);
Route::post('/album', [AlbumController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/album/{id}', [AlbumController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/album/{id}', [AlbumController::class, 'destroy'])->middleware('auth:sanctum');
//--Album/Song--
Route::get('/album/{id}/songs', [AlbumController::class, 'index_song']);
Route::post('/album/{id}/song', [AlbumController::class, 'store_song'])->middleware('auth:sanctum');
Route::patch('/album/{album_id}/song/{id}', [AlbumController::class, 'update_song'])->middleware('auth:sanctum');
Route::delete('/album/{album_id}/song/{id}', [AlbumController::class, 'destroy_song'])->middleware('auth:sanctum');
//--Song--
Route::get('/songs', [SongController::class, 'index']);
Route::post('/song', [SongController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/song/{id}', [SongController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/song/{id}', [SongController::class, 'destroy'])->middleware('auth:sanctum');
//--User--
Route::post('/user/login', [UserController::class, 'login']);
Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');