<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//routing for User
Route::post('/create-user', [UserController::class, 'createUser']);
Route::post('/create-admin', [UserController::class, 'createAdmin']);
Route::post('/login', [UserController::class, 'userLogin'])->name('user.login');

//Route::post('login', [ 'as' => 'login', 'uses' => [UserController::class, 'userLogin']]);

Route::group(['middleware' => 'auth:api'], function () {

    Route::get("detail-user", [UserController::class, 'userDetail']);
    Route::delete("delete-user/{id}", [UserController::class, 'deleteUser']);
    Route::put("update-user", [UserController::class, 'updateUser']);
    

    Route::post('create-todo',[TodoController::class,'store']);
    Route::put('complete/{id}',[TodoController::class,'update']);
    Route::delete('delete/{id}',[TodoController::class,'destroy']); 
    Route::post('edit/{id}',[TodoController::class,'edit']); 
    
  
});

//routing for Todo
Route::get('/todos',[TodoController::class,'index'])->middleware('auth:api');

// Route::prefix('/todos')->group( function (){

//     Route::post('/create',[TodoController::class,'store']);
//     Route::put('/{id}',[TodoController::class,'update']);
//     Route::delete('/{id}',[TodoController::class,'destroy']); 

// });


