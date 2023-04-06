<?php

use App\Http\Controllers\TaskController;
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

Route::get('/', [TaskController::class, 'index'])->name('index');
Route::get('/tasks/search', [TaskController::class, 'search'])->name('task.search');
Route::resource('task', TaskController::class);
Route::get('/api/task-index/{query?}', [TaskController::class, 'searchTask'])->name('api.task.index');
