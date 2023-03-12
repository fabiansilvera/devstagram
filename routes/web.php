<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PostController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');

// Rutas de Registro de Usuario
Route::get('/registrarse', [RegisterController::class, 'index'])->name('register');
Route::post('/registrarse', [RegisterController::class, 'store']);

// Rutas de Login y logout de usuario
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

// Rutas para el Perfil
Route::get('/editar-perfil', [PerfilController::class , 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class , 'store'])->name('perfil.store');

// Rutas de dashboard de usuario y sus publicaciones
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Ruta de almacenamiento de imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Comentarios
Route::post('/{user:username}posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// Likes
Route::post('posts/{post}/likes',[LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('posts/{post}/likes',[LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Siguiendo Usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/follow', [FollowerController::class, 'destroy'])->name('users.unfollow');

