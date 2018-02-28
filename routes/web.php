<?php

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

Route::get('/', function () {
    return view('welcome');
});

// The code is in the namespace API, file VehicleAPIController
Route::group(['namespace' => 'API'], function(){
	// the Method post in the Requirement 2
	Route::post('vehicles', 'VehicleAPIController@postVehicles');
	// the Method post in the Requirement 1 and 3
	Route::get('vehicles/{modelYear}/{manufacture}/{model}', 'VehicleAPIController@getVehicles');
	Route::get('vehicles/{modelYear}/{manufacture}', 'VehicleAPIController@getEmptyResponse');
	Route::get('vehicles/{modelYear}', 'VehicleAPIController@getEmptyResponse');
	Route::get('vehicles', 'VehicleAPIController@getEmptyResponse');
});

// code to access the swagger.json
Route::get('/json/{filename}', function($filename){
    $path = resource_path() . '/assets/json/' . $filename;

    if(!File::exists($path)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});