<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TaskController;

Auth::routes();
Route::get('/', function () {
  return redirect()->route('login');
});
Route::group(['prefix' => '{tenant_slug}', 'middleware' => ['tenant.identify', 'auth:sanctum']], function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

  Route::resource('teams', TeamController::class);
  Route::resource('teams.projects', ProjectController::class)->shallow();
  Route::resource('projects.tasks', TaskController::class)->shallow();

  Route::get('/my-tasks', [TaskController::class, 'myTasks']);
  Route::patch('/tasks/{task}/complete', [TaskController::class, 'markComplete']);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
