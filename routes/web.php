<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Super\UserManagerController;
use App\Http\Controllers\Super\TableClassController;
use App\Http\Controllers\Super\TableController;
use App\Http\Controllers\Super\MenuTypeController;
use App\Http\Controllers\Super\MenuController;

Sentinel::disableCheckpoints();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('iniuse', function(){
// 	$role = Sentinel::findRoleById('2');
// 	$credentials = [
// 	    'email'    => 'sipil.ft@uniwa.ac.id',
// 	    'password' => 'sipil.ft717',
// 		'first_name' => 'Unknown',
// 		'last_name' => '',
// 		'phone' => '8xx',
// 		'username' => '07108765',
// 	];
// 	$user = Sentinel::registerAndActivate($credentials);
// 	$role->users()->attach($user);
// });

//UserController
// Route::get('/', [PenelusuranPerkaraController::class,'index']);
Route::get('login', [UserController::class,'login']);
Route::post('login', [UserController::class,'postLogin']);

Route::get('/',[BerandaController::class,'index']);


Route::group(['middleware' => 'sentinelmember'], function(){
	Route::group(['prefix'=>'dashboard'],function(){
		Route::get('/', [DashboardController::class,'index']);
		Route::post('/periode', [DashboardController::class,'getChartSAByPeriode']);
		Route::post('/periode-by-prodi', [DashboardController::class,'getChartKAByPeriode']);
		Route::post('/periode-lulus-by-prodi', [DashboardController::class,'getChartKAByPeriodeLulus']);
		Route::get('/test',[DashboardController::class,'test']);
	});
	

	Route::get('user-profile',[UserController::class,'userProfile']);
	Route::post('user-profile-update-profil',[UserController::class,'update']);
	Route::post('user-profile-update-password',[UserController::class,'updatePassword']);	

	Route::get('logout',[UserController::class,'logout']);
});



Route::group(['middleware' => 'SAmember'],function(){	
	Route::group(['prefix' => 'master'], function(){
		Route::group(['prefix' => 'table-class'], function(){
			Route::get('/', [TableClassController::class,'index']);
			Route::post('/list', [TableClassController::class,'getTableClassList']);
			Route::post('/',[TableClassController::class,'store']);
			Route::post('/update',[TableClassController::class,'update']);
			Route::delete('', [TableClassController::class,'destroy']);
		});
		Route::group(['prefix' => 'table'], function(){
			Route::get('/', [TableController::class,'index']);
			Route::post('/list', [TableController::class,'getTableList']);
			Route::post('/',[TableController::class,'store']);
			Route::post('/update',[TableController::class,'update']);
			Route::delete('', [TableController::class,'destroy']);
		});
		Route::group(['prefix' => 'menu-type'], function(){
			Route::get('/', [MenuTypeController::class,'index']);
			Route::post('/list', [MenuTypeController::class,'getMenuTypeList']);
			Route::post('/',[MenuTypeController::class,'store']);
			Route::post('/update',[MenuTypeController::class,'update']);
			Route::delete('', [MenuTypeController::class,'destroy']);
		});
		Route::group(['prefix' => 'menu'], function(){
			Route::get('/', [MenuController::class,'index']);
			Route::post('/list', [MenuController::class,'getMenuList']);
			Route::post('/',[MenuController::class,'store']);
			Route::post('/update',[MenuController::class,'update']);
			Route::delete('', [MenuController::class,'destroy']);
		});
	});
	Route::group(['prefix' => 'master/user-manager'], function(){
			Route::get('/', [UserManagerController::class,'index']);
			Route::post('/list', [UserManagerController::class, 'getUsers']);
			Route::post('/',[UserManagerController::class,'store']);
			Route::post('/update',[UserManagerController::class,'update']);
			Route::delete('', [UserManagerController::class,'destroy']);			
	});
});

// No Permission
Route::get('notfound',function(){
	return abort(404);
});