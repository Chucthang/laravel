<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CallApi extends Controller
{
    public function GetBrand()
    {
        $client =  new Client([
            'headers' => ['content-type' => 'application/json',
                        'Accept' => 'application/json'],
        ]);

        $res =  $client->request('GET','https://leminhtien.herokuapp.com/api/getbrand',[
            'json' => [
                'code' => 'getbrand'
            ]
        ]);
    
        $data = json_decode($res->getBody());
        dd($data);
        // return view('welcome',['brand'=> $data]);

    }
}
