<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LoginAuth;

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
// Route::middleware(['web'])->group(function () {
    


   
    Route::post('region/elchi', [App\Http\Controllers\NovatioController::class,'region']);
    Route::post('region/chart', [App\Http\Controllers\NovatioController::class,'regionChart']);


Auth::routes();

Route::get('login', function(){
    return view('auth.login');
})->name('sign-in');
// Route::get('admin', function(){
//     return view('admin.login');
// })->name('admin-login');
Route::post('/home', [LoginController::class, 'login'])->name('login');
// Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

// Route::middleware([LoginAuth::class])->group(function () {

// });

Route::post('/admin', [LoginController::class, 'loginAdmin'])->name('login-admin');
Route::middleware([LoginAdmin::class])->group(function () {

});

Route::middleware([LoginAuth::class])->group(function () {

    Route::get('/',[HomeController::class,'index'])->name('blackjack');
    Route::get('/search',[HomeController::class,'filter']);
Route::get('elchi/{id}/{time?}', [HomeController::class,'elchi'])->name('elchi');
Route::get('elchi-list', [HomeController::class,'elchiList'])->name('elchi-list');
Route::get('user-list', [HomeController::class,'userList'])->name('user-list');
Route::get('/status', [HomeController::class,'userOnlineStatus']);
#position
Route::resource('position', PositionController::class);
Route::get('position//{id?}/delete', [App\Http\Controllers\PositionController::class,'destroy'])->name('position.delete');
Route::get('user-list', [HomeController::class,'userList'])->name('user-list');
Route::get('pro-list/{time}', [HomeController::class,'proList'])->name('pro-list');
Route::post('permission', [HomeController::class,'permission'])->name('permissions');
Route::get('reg', [HomeController::class,'reg']);

#end-position

});

// });