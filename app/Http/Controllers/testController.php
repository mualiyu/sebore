<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class testController extends Controller
{

    public function index()
    {
        $id = 2;
        $name = "aliyu muktar";
        $phone = "08127455859";
        $code = "123456789";
        $apiUser = '6c00b253-0b01-4630-b7a0-187438021083';
        $apiKey = '6c00b253-0b01-4630-b7a0-187438021083';
        $agentId = "54ba1901-09ef-43f0-8c80-ca6229b41dd9";

        $hash = hash('sha512', $name . $agentId . $phone . $code);

        // dd($hash);


        $array = [
            'apiUser' => $apiUser,
            'apiKey' => $apiKey,
            'hash' => $hash,
            'name' => $name,
            'agentId' => $agentId,
            'phone' => $phone,
            'code' => $code,

        ];

        $url = 'https://api.ajisaqsolutions.com/api/customer/add?apiUser=' .
            $apiUser . '&apiKey=' .
            $apiKey . '&hash=' .
            $hash . '&name=' .
            $name . '&agentId=' .
            $agentId . '&phone=' .
            $phone . '&code=' .
            $code . '';

        $response = Http::post($url);

        if ($response) {
            $arr = json_decode($response);
            dd($arr);
        }

        return "error";
    }
}
