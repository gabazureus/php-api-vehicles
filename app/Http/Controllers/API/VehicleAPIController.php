<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
// import to GuzzleHttp
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VehicleAPIController extends AppBaseController
{
	 /**
     * Display a listing of the Vehicles
     * GET /vehicles
     *
     * @param Request $request
	 * @param $modelYear
	 * @param $manufacture
	 * @param $model
     * @return JSON $get with the list
     */
    public function getVehicles(Request $request, $modelYear, $manufacture, $model)
    {
    	// get all the params from the request
    	$res = $request->all();

    	// verify if the modelYear is not a numeric or is undefined, if so, return the 'empty' JSON.
    	if (empty($modelYear) || empty($manufacture) || empty($model) || $modelYear === 'undefined' || !is_numeric($modelYear))
    		return '{"Count":0,"Results":[]}';

    	// create a new GuzzleHttp library to perform the HTTP GET to external API
    	$client = new Client();

    	// do a get inside the NHTSA API with the params
		$get = $client->get('https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/'. $modelYear . '/make/'. $manufacture . '/model/'. $model, ['query' => ['format' =>  'json']]);

		// decode json to remove 'Message'
		$get = json_decode($get->getBody());

		// removing the value
		unset($get->Message);

		// verify if the param withRating was passed and if it is true
		if (array_key_exists('withRating', $res) && $res['withRating'] == 'true') {
			$i = 0;

			// make a foreach to get all the Vehicles inside the dataset and insert the CrashRating and iterate inside the Results with $i
			foreach ($get->Results as $data) {
				$vehicleId = $data->VehicleId;
				
				// send a get to the NHTSA API
				$getRating = $client->get('https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/'. $vehicleId, ['query' => ['format' =>  'json']]);
				// decode the body of the response
		    	$getRating = json_decode($getRating->getBody());

		    	// verify if the result has the 'Results' field and if it is not empty, and if so, it will be Not Rated
		    	if (array_key_exists('Results', $getRating) && !empty($getRating->Results)) {
		    		$getRating = $getRating->Results;
		    		// get the first result
			    	$getRating = $getRating[0];

			    	// verify if it has the field OverallRating
			    	if (array_key_exists('OverallRating', $getRating))
			    		$getRating = $getRating->OverallRating;
			    	// verify if it is not a numeric, if so, it will be Not Rated
			    	if (!is_numeric($getRating))
			    		$getRating = 'Not Rated';
				}
				else
					$getRating = 'Not Rated';
		    	
		    	// save the CrashRating to the Vehicle
		    	$get->Results[$i]->CrashRating = $getRating;
		    	$i++;
			}
		}

		// and back to json
		$get = str_replace('"VehicleDescription"', '"Description"', json_encode($get));

        return $get;
    }

    public function getEmptyResponse($a = null, $b = null) {
    	return '{"Count":0,"Results":[]}';
    }

    public function postVehicles(Request $request) {
    	// get all the requests params
    	$res = $request->all();

    	// verify if all the params was correctly passed
    	if (!array_key_exists('modelYear', $res) || !array_key_exists('manufacture', $res) || !array_key_exists('model', $res))
    		return '{"Count":0,"Results":[]}';

    	// call the getVehicles with the params
    	return $this->getVehicles($request, $res['modelYear'], $res['manufacture'], $res['model']);
    }
}
