<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use Swaggest\JsonDiff\JsonDiff;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class VehiclesApiTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function testPostVehiclesWithRating()
    {
        $client = new Client();

        $post = $client->post('http://127.0.0.1:8000/vehicles', ['query' => ['modelYear' => 2015, 'manufacture' => 'Audi', 'model' => 'A3', 'withRating' => 'true']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 4,
                                    "Results": [
                                        {
                                            "CrashRating": "5",
                                            "Description": "2015 Audi A3 4 DR AWD",
                                            "VehicleId": 9403
                                        },
                                        {
                                            "CrashRating": "5",
                                            "Description": "2015 Audi A3 4 DR FWD",
                                            "VehicleId": 9408
                                        },
                                        {
                                            "CrashRating": "Not Rated",
                                            "Description": "2015 Audi A3 C AWD",
                                            "VehicleId": 9405
                                        },
                                        {
                                            "CrashRating": "Not Rated",
                                            "Description": "2015 Audi A3 C FWD",
                                            "VehicleId": 9406
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($post->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test POST /vehicles?modelYear=2015&manufacture=Audi&model=A3&withRating=true : OK\n\n";
    }

    public function testPostVehicles()
    {
        $client = new Client();

        $post = $client->post('http://127.0.0.1:8000/vehicles', ['query' => ['modelYear' => 2015, 'manufacture' => 'Audi', 'model' => 'A3', 'withRating' => 'false']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 4,
                                    "Results": [
                                        {
                                            "Description": "2015 Audi A3 4 DR AWD",
                                            "VehicleId": 9403
                                        },
                                        {
                                            "Description": "2015 Audi A3 4 DR FWD",
                                            "VehicleId": 9408
                                        },
                                        {
                                            "Description": "2015 Audi A3 C AWD",
                                            "VehicleId": 9405
                                        },
                                        {
                                            "Description": "2015 Audi A3 C FWD",
                                            "VehicleId": 9406
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($post->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test POST /vehicles?modelYear=2015&manufacture=Audi&model=A3&withRating=false : OK\n\n";
    }

    public function testPostVehiclesToyotaYaris()
    {
        $client = new Client();

        $post = $client->post('http://127.0.0.1:8000/vehicles', ['query' => ['modelYear' => 2015, 'manufacture' => 'Toyota', 'model' => 'Yaris', 'withRating' => 'bananas']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 2,
                                    "Results": [
                                        {
                                            "Description": "2015 Toyota Yaris 3 HB FWD",
                                            "VehicleId": 9791
                                        },
                                        {
                                            "Description": "2015 Toyota Yaris Liftback 5 HB FWD",
                                            "VehicleId": 9146
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($post->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test POST /vehicles?modelYear=2015&manufacture=Toyota&model=Yaris&withRating=bananas : OK\n\n";
    }

    public function testPostVehiclesWithoutModelYear()
    {
        $client = new Client();

        $post = $client->post('http://127.0.0.1:8000/vehicles', ['query' => ['manufacture' => 'Toyota', 'model' => 'Yaris']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count":0,
                                    "Results":[]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($post->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test POST /vehicles?manufacture=Toyota&model=Yaris (without modelYear) : OK!\n\n";
    }

    /**
     * @test
     */
    public function testGetVehicles()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Audi/A3');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 4,
                                    "Results": [
                                        {
                                            "Description": "2015 Audi A3 4 DR AWD",
                                            "VehicleId": 9403
                                        },
                                        {
                                            "Description": "2015 Audi A3 4 DR FWD",
                                            "VehicleId": 9408
                                        },
                                        {
                                            "Description": "2015 Audi A3 C AWD",
                                            "VehicleId": 9405
                                        },
                                        {
                                            "Description": "2015 Audi A3 C FWD",
                                            "VehicleId": 9406
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/2015/Audi/A3 : OK\n\n";
    }

    public function testGetVehiclesToyotaYaris()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Toyota/Yaris');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 2,
                                    "Results": [
                                        {
                                            "Description": "2015 Toyota Yaris 3 HB FWD",
                                            "VehicleId": 9791
                                        },
                                        {
                                            "Description": "2015 Toyota Yaris Liftback 5 HB FWD",
                                            "VehicleId": 9146
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/2015/Toyota/Yaris : OK!\n\n";
    }

    /**
     * @test
     */
    public function testGetVehiclesWithRating()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Audi/A3', ['query' => ['withRating' => 'true']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 4,
                                    "Results": [
                                        {
                                            "CrashRating": "5",
                                            "Description": "2015 Audi A3 4 DR AWD",
                                            "VehicleId": 9403
                                        },
                                        {
                                            "CrashRating": "5",
                                            "Description": "2015 Audi A3 4 DR FWD",
                                            "VehicleId": 9408
                                        },
                                        {
                                            "CrashRating": "Not Rated",
                                            "Description": "2015 Audi A3 C AWD",
                                            "VehicleId": 9405
                                        },
                                        {
                                            "CrashRating": "Not Rated",
                                            "Description": "2015 Audi A3 C FWD",
                                            "VehicleId": 9406
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/2015/Audi/A3?withRating=true : OK!\n\n";
    }

    public function testGetVehiclesToyotaYarisWithRating()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Toyota/Yaris', ['query' => ['withRating' => 'true']]);

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count": 2,
                                    "Results": [
                                        {
                                            "CrashRating":"Not Rated",
                                            "Description": "2015 Toyota Yaris 3 HB FWD",
                                            "VehicleId": 9791
                                        },
                                        {
                                            "Description": "2015 Toyota Yaris Liftback 5 HB FWD",
                                            "VehicleId": 9146,
                                            "CrashRating":"4"
                                        }
                                    ]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/2015/Toyota/Yaris?withRating=true : OK!\n\n";
    }

    public function testGetVehiclesUndefined()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/undefined/Audi/A3');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count":0,
                                    "Results":[]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/undefined/Audi/A3 : OK!\n\n";
    }

    public function testGetVehiclesBananas()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/bananas/Audi/A3');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count":0,
                                    "Results":[]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/bananas/Audi/A3 : OK!\n\n";
    }

    public function testGetVehiclesCrowdVictoria()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Ford/Crowd Victoria');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count":0,
                                    "Results":[]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "test GET /vehicles/2015/Ford/Crowd Victoria : OK!\n\n";
    }

    public function testGetVehiclesWithoutModel()
    {
        $client = new Client();

        $get = $client->get('http://127.0.0.1:8000/vehicles/2015/Ford');

        // expected json presented in the php-api-assignment.md to input test "2015 Audi A3"
        $expected = json_decode('{
                                    "Count":0,
                                    "Results":[]
                                }');

        // compare the result of my API with the json expected
        $r = new JsonDiff(json_decode($get->getBody()), $expected);

        // test if Patch from Swaggest/JsonDiff is empty, if so, everything is ok with the response
        $this->assertTrue(empty($r->getPatch()->jsonSerialize()));
        echo "\n\ntest GET /vehicles/2015/Ford (without Model) : OK!\n\n";
    }
}
