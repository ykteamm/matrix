<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});


Route::get('/battle', function(){
    $json = [
        [
        'start_date' => '2023-01-04',
        'end_date' => '2023-01-06',
        'user1_name' => 'Ismatova K', 
        'user1_sold' => '1900000',
        'user1_kubok' => '34',
        'user1_image' => 'https://api.multiavatar.com/kathrin.svg',
        'user2_name' => 'Nargiza K', 
        'user2_sold' => '1600000',
        'user2_kubok' => '-24',
        'user2_image' => 'https://api.multiavatar.com/kathrin.svg',  
        'days' => [[
            'date' => '2023-01-04',
            'user1_name' => 'Ismatova K', 
            'user1_sold' => '500000',
            'user2_name' => 'Nargiza K', 
            'user2_sold' => '400000',
        ],
        [
            'date' => '2023-01-05',
            'user1_name' => 'Ismatova K', 
            'user1_sold' => '400000',
            'user2_name' => 'Nargiza K', 
            'user2_sold' => '500000',
        ],[
            'date' => '2023-01-06',
            'user1_name' => 'Ismatova K', 
            'user1_sold' => '1000000',
            'user2_name' => 'Nargiza K', 
            'user2_sold' => '700000',
        ]]
        ],
        [
            'start_date' => '2023-01-07',
            'end_date' => '2023-01-09',
            'user1_name' => 'Ismatova K', 
            'user1_sold' => '1800000',
            'user1_kubok' => '-28',
            'user1_image' => 'https://api.multiavatar.com/kathrin.svg',
            'user2_name' => 'Nargiza K', 
            'user2_sold' => '2600000',
            'user2_kubok' => '41',
            'user2_image' => 'https://api.multiavatar.com/kathrin.svg',  
            'days' => [[
                'date' => '2023-01-07',
                'user1_name' => 'Ismatova K', 
                'user1_sold' => '700000',
                'user2_name' => 'Nargiza K', 
                'user2_sold' => '600000',
            ],
            [
                'date' => '2023-01-08',
                'user1_name' => 'Ismatova K', 
                'user1_sold' => '700000',
                'user2_name' => 'Nargiza K', 
                'user2_sold' => '800000',
            ],[
                'date' => '2023-01-09',
                'user1_name' => 'Ismatova K', 
                'user1_sold' => '400000',
                'user2_name' => 'Nargiza K', 
                'user2_sold' => '1200000',
            ]]
            ]
    ];

    return response()->json($json);
});



// Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
// Route::get('/test', [TestController::class,'test']);
// Route::resource('patient', PatientController::class);
// });