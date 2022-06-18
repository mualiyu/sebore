<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class testController extends Controller
{

    // public function index()
    // {
    //     $id = 2;
    //     $name = "aliyu muktar";
    //     $phone = "08127455859";
    //     $code = "123456789";
    //     $apiUser = '6c00b253-0b01-4630-b7a0-187438021083';
    //     $apiKey = '6c00b253-0b01-4630-b7a0-187438021083';
    //     $agentId = "54ba1901-09ef-43f0-8c80-ca6229b41dd9";

    //     $hash = hash('sha512', $name . $agentId . $phone . $code);

    //     // dd($hash);


    //     $array = [
    //         'apiUser' => $apiUser,
    //         'apiKey' => $apiKey,
    //         'hash' => $hash,
    //         'name' => $name,
    //         'agentId' => $agentId,
    //         'phone' => $phone,
    //         'code' => $code,

    //     ];

    //     $url = 'https://api.ajisaqsolutions.com/api/customer/add?apiUser=' .
    //         $apiUser . '&apiKey=' .
    //         $apiKey . '&hash=' .
    //         $hash . '&name=' .
    //         $name . '&agentId=' .
    //         $agentId . '&phone=' .
    //         $phone . '&code=' .
    //         $code . '';

    //     $response = Http::post($url);

    //     if ($response) {
    //         $arr = json_decode($response);
    //         dd($arr);
    //     }

    //     return "error";
    // }

    public function index()
    {
        return view('plan.index');
        // // $name = "aliyu muktar";
        // // $phone = "08127455859";
        // // $code = "123456789";
        // $apiUser = '6c00b253-0b01-4630-b7a0-187438021083';
        // $apiKey = '6c00b253-0b01-4630-b7a0-187438021083';
        // $Id = "e3e9dbcc-008f-4618-a1e3-9c5d6ec74dba";
        // $deviceId = "9948e3cb-1a4c-4826-b0a0-a743949e9ec3";
        // $itemId = "fb200d22-d509-4728-845c-77823ccd000b";

        // $hash = hash(
        //     'sha512',
        //     $Id
        // );

        // $hash_d = hash(
        //     'sha512',
        //     $deviceId
        // );

        // $hash_i = hash(
        //     'sha512',
        //     $itemId
        // );


        // // customers
        // $url = 'https://api.ajisaqsolutions.com/api/customer/get?apiUser=' .
        //     $apiUser . '&apiKey=' .
        //     $apiKey . '&hash=' .
        //     $hash .
        //     // '&name=' .$name . 
        //     '&id=' . $Id;

        // $response = Http::get($url);

        // if ($response) {
        //     $arr = json_decode($response);
        //     // dd($arr);
        // }

        // // devices
        // $urll = 'https://api.ajisaqsolutions.com/api/device/get?apiUser=' .
        //     $apiUser . '&apiKey=' .
        //     $apiKey . '&hash=' .
        //     $hash_d .
        //     // '&name=' .$name . 
        //     '&id=' . $deviceId;

        // $response_d = Http::get($urll);

        // if ($response_d) {
        //     $arr = json_decode($response_d);
        //     // dd($arr);
        // }


        // // devices
        // $url_i = 'https://api.ajisaqsolutions.com/api/item/get?apiUser=' .
        //     $apiUser . '&apiKey=' .
        //     $apiKey . '&hash=' .
        //     $hash_i .
        //     // '&name=' .$name . 
        //     '&id=' . $itemId;

        // $response_i = Http::get($url_i);

        // if ($response_i) {
        //     $arr = json_decode($response_i);
        //     // dd($arr);
        // }


        // sk_test_fe421e6b74b548c60c836c64028c9119
        // pk_live_e0dbe1bec398b4681df1f89c1b8e3176
        // "refreshToken": "61198e70989c6622e630f8f861faa30403ca061f",
        // "accessToken": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjYxMTk4ZTcwOTg5YzY2MjJlNjMwZjhmOCIsIm1vYmlsZSI6IjIzNDgxNjcyMzY2MjkiLCJpYXQiOjE2MjkwNjUxOTAsImV4cCI6MTYyOTE1MTU5MH0.XxjRLNveKR4zF42hoeqz4RWIKBNFh6KD9QiIF1CYyB8",


        // $ress = Http::withHeaders([
        //     'Content-Type' => 'application/json ',
        //     'X-App-Key' => 'fa143c301f52c820895717ee1a7af1c7',
        //     'X-App-Wallet-Access-Token' => 'd364504f846c2d8b61e25620d71ab0930fb745deb21ca49d14fa57425dabfe93',
        // ])->get('https://api.console.eyowo.com/v1/users/balance');

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json ',
        //     'X-App-Key' => 'pk_live_e0dbe1bec398b4681df1f89c1b8e3176',
        //     'X-App-Wallet-Access-Token' => '',
        // ])->post('https://api.console.eyowo.com/v1/users/transfers/phone', [
        //     'mobile' => '2348167236629',
        //     'amount' => '100',
        // ]);

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json ',
        //     'X-App-Key' => 'pk_live_e0dbe1bec398b4681df1f89c1b8e3176',
        //     'X-App-Wallet-Access-Token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjYxMTk4ZTcwOTg5YzY2MjJlNjMwZjhmOCIsIm1vYmlsZSI6IjIzNDgxNjcyMzY2MjkiLCJpYXQiOjE2MjkwNjUxOTAsImV4cCI6MTYyOTE1MTU5MH0.XxjRLNveKR4zF42hoeqz4RWIKBNFh6KD9QiIF1CYyB8',
        // ])->post('https://api.console.eyowo.com/v1/users/transfers/phone', [
        //     'mobile' => '2348127455859',
        //     'amount' => '100',
        // ]);
        // $res = json_decode($response);
        // dd($res);

        // $id = '2011';
        // $apiUsername = 'muktar';
        // $role = 'USER';
        // $userKey = '20111755';
        // $hash = hash('sha512', $userKey . $apiUsername . $role);

        // $url = 'https://api.ajisaqsolutions.com/api/apiUser/add?apiUser=' .
        //     config('app.apiUser') . '&apiKey=' .
        //     config('app.apiKey') . '&hash=' .
        //     $hash . '&id=' .
        //     $id . '&apiUsername=' .
        //     $apiUsername . '&role=' .
        //     $role . '&userKey=' . $userKey;

        // $response = Http::post($url);

        // $res = json_decode($response);

        // return $response;


        // $id = '7';
        // $name = "g name";
        // $description = 'g_description';
        // $logo = url('/storage/pic/default.jpg');
        // $phone = '09167843245';
        // $hash = hash('sha512', $name . $description . $logo . $phone);

        // $url = 'https://api.ajisaqsolutions.com/api/organization/add?apiUser=2&apiKey=1234' . '&hash=' .
        //     $hash . '&id=' .
        //     $id . '&name=' .
        //     $name . '&description=' .
        //     $description . '&logoUrl=' .
        //     $logo . '&phone=' . $phone;

        // $response = Http::post($url);

        // $res = json_decode($response);

        // return  $response;
    }

    public function insert()
    {
        $amount = "100";
        $q = "2";
        $d = "15-08-2021";
        $t_s = "15-08-2021";
        $apiUser = '6c00b253-0b01-4630-b7a0-187438021083';
        $apiKey = '6c00b253-0b01-4630-b7a0-187438021083';
        $agentId = "b39c4ecd-3fb5-4b8a-b4ad-3af8a694426c";
        $deviceId = "9948e3cb-1a4c-4826-b0a0-a743949e9ec3";
        $customerId = "badc83a8-fbdd-4c4e-aa13-f24e8d3315c3";
        $itemId = "fb200d22-d509-4728-845c-77823ccd000b";

        $hash = hash('sha512', $agentId . $deviceId . $itemId . $customerId . $q . $d . $amount . $t_s);

        $url = 'https://api.ajisaqsolutions.com/api/transaction/add?apiUser=' .
            $apiUser . '&apiKey=' .
            $apiKey . '&hash=' .
            $hash . '&agentId=' .
            $agentId .
            '&deviceId=' . $deviceId .
            '&itemId=' . $itemId .
            '&customerId=' . $customerId .
            '&quantity=' . $q .
            '&date=' . $d .
            '&amount=' . $amount .
            '&timeStamp=' . $t_s;
        // dd(now());
        $response = Http::post($url);

        if ($response) {
            $arr = json_decode($response);
            dd($arr);
        }

        return "error";
    }
}
