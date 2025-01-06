<?php
use App\Http\Controllers\Auth\AuthJwtController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtAuthentication;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Tasks\TasksController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

/**Test Server */
Route::get('/', function (Request $request) {
    return response()->json(['message' => 'App is running ...'], 200);
});

/**ROUTES FOR AUTH */
Route::post('register', [AuthJwtController::class, 'register']);
Route::post('login', [AuthJwtController::class, 'login']);
Route::post('logout', [AuthJwtController::class, 'logout']);


Route::middleware([JwtAuthentication::class])->group(function () {
    Route::post('check_token', [AuthJwtController::class, 'checkToken']);
    Route::get('user', [AuthJwtController::class, 'user']);

    /**ROUTES FOR USERS */
    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::post('users', [UsersController::class, 'store']);
    Route::patch('users/{id}', [UsersController::class, 'update']);
    Route::delete('users/{id}', [UsersController::class, 'destroy']);

    /**ROUTES FOR TASKS */
    Route::get('tasks', [TasksController::class, 'index']);
    Route::get('tasks/{id}', [TasksController::class, 'show']);
    Route::post('tasks', [TasksController::class, 'store']);
    Route::patch('tasks/{id}', [TasksController::class, 'update']);
    Route::delete('tasks/{id}', [TasksController::class, 'destroy']);
});