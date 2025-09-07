<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Super\UserManagerController;
use App\Http\Controllers\Super\PlaceCategoryController;
use App\Http\Controllers\Super\PlaceController;
use App\Http\Controllers\Super\MenuTypeController;
use App\Http\Controllers\Super\MenuController;
use App\Http\Controllers\Super\LiveOrderController;
use App\Http\Controllers\Super\RiwayatOrderController;

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

Route::get('/',[BerandaController::class,'index'])->name('beranda');
Route::get('/menu',[BerandaController::class,'indexMenu'])->middleware('check.place')->name('menu');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/view', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cart.remove');
Route::post('/cart/update-note', [CartController::class, 'updateNote'])->name('cart.updateNote');

Route::get('/scan', [ScanController::class, 'index'])->name('scan.qr');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order}/pay', [PaymentController::class, 'pay'])->name('payment.pay');


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

	Route::group(['prefix'=>'order'],function(){
		Route::group(['prefix'=>'live'],function(){
			Route::get('/', [LiveOrderController::class,'index']);			
			Route::post('/list', [LiveOrderController::class,'getOrderList']);
			Route::get('/{order}/detail', [LiveOrderController::class, 'detail'])->name('kasir.live-order.detail');
			Route::get('/{order}/invoice', [LiveOrderController::class, 'invoice'])->name('kasir.live-order.invoice');
			Route::post('/payment/{order}', [LiveOrderController::class, 'payment'])->name('kasir.payment');
			Route::post('/cancel/{order}', [LiveOrderController::class, 'cancel'])->name('kasir.cancel');
			Route::post('/ready/{order}', [LiveOrderController::class, 'ready'])->name('kasir.ready');
			Route::post('/done/{order}', [LiveOrderController::class, 'done'])->name('kasir.done');
			Route::get('/{order}/nota', [LiveOrderController::class, 'nota'])->name('kasir.live-order.nota');
		});
		Route::group(['prefix'=>'riwayat'],function(){
			Route::get('/', [RiwayatOrderController::class,'index']);			
			Route::post('/list', [RiwayatOrderController::class,'getOrderList']);
		});
	});

	Route::get('logout',[UserController::class,'logout']);
});

Route::group(['middleware' => 'KOKImember'],function(){	
	Route::group(['prefix' => 'master'], function(){
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
});



Route::group(['middleware' => 'SAmember'],function(){	
	Route::group(['prefix' => 'master'], function(){
		Route::group(['prefix' => 'place-category'], function(){
			Route::get('/', [PlaceCategoryController::class,'index']);
			Route::post('/list', [PlaceCategoryController::class,'getPlaceCategoryList']);
			Route::post('/',[PlaceCategoryController::class,'store']);
			Route::post('/update',[PlaceCategoryController::class,'update']);
			Route::delete('', [PlaceCategoryController::class,'destroy']);
		});
		Route::group(['prefix' => 'place'], function(){
			Route::get('/', [PlaceController::class,'index']);
			Route::post('/list', [PlaceController::class,'getPlaceList']);
			Route::post('/',[PlaceController::class,'store']);
			Route::post('/update',[PlaceController::class,'update']);
			Route::delete('', [PlaceController::class,'destroy']);
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

Route::get('/notifications', function () {
    $user = Sentinel::getUser();
    return response()->json([
        'unread_count' => $user->unreadNotifications()->count(),
        'notifications' => $user->unreadNotifications()->take(10)->get(),
    ]);
})->name('notifications');

Route::post('/notifications/read/{id}', function ($id) {
    $user = Sentinel::getUser();
    $notification = $user->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
    }
    return response()->json(['success' => true]);
})->name('notifications.read');

Route::post('/notifications/read-all', function () {
    $user = Sentinel::getUser();
    $user->unreadNotifications->markAsRead();

    return response()->json(['success' => true]);
})->name('notifications.readAll');