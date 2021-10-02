<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $ex = explode(' ', $row['date']);
        // $ex1 = explode('/', $ex[0]);
        // $day = '20' . $ex1[2] . '-' . $ex1[1] . '-' . $ex1[0];
        // $time = $ex[1] . ':00';
        // $date = $day . " " . $time;

        // $x = str_replace(',', '', $row['amount']);

        $new = substr($row['phone'], -10);
        $num = '0' . $new;

        $agent = Agent::find($this->id);

        $customer = Customer::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $num,
            'gps' => $row['location'],
            'state' => $row['state'],
            'country' => $row['country'],
            'address' => $row['address'],
            'lga' => $row['lga'],
            'agent_id' => $this->id,
            'org_id' => Auth::user()->organization_id,
        ]);

        Customer::where('id', '=', $customer->id)->update([
            'agent_id' => $this->id,
            'org_id' => Auth::user()->organization_id,
        ]);

        // //Api
        // $hash = hash(
        //     'sha512',
        //     $row['name'] .
        //         $agent->phone .
        //         $num .
        //         $num
        // );

        // $url = 'https://api.ajisaqsolutions.com/api/customer/add?apiUser=' .
        //     config('app.apiUser') . '&apiKey=' .
        //     config('app.apiKey') . '&hash=' .
        //     $hash .  '&id=' .
        //     $customer->phone .  '&name=' .
        //     $row['name'] . '&agentId=' .
        //     $agent->phone . '&phone=' .
        //     $num . '&code=' .
        //     $num;

        // try {
        //     $response = Http::post($url);
        //     $res = json_decode($response);
        // } catch (\Throwable $th) {
        //     // return back()->with(['error' => 'Sorry, An error was encountered. Come back later!']);
        // }
        // //End api

        return $customer;
    }

    public function headingRow(): int
    {
        return 2;
    }
}
