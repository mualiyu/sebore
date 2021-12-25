<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $new = substr($row['phone'], -10);
        $num = '0' . $new;

        $agent = Agent::find($this->id);

        $cus = Customer::where('phone', '=', $num)->get();

        if (count($cus) > 0) {
            $a_c = DB::table('agent_customer')->where(['agent_id' => $agent->id, 'customer_id' => $cus[0]->id])->get();
            if (count($a_c) > 0) {
            } else {
                $agent_customer = DB::table('agent_customer')->insert([
                    'agent_id' => $agent->id,
                    'customer_id' => $cus[0]->id
                ]);
            }
            return $cus[0];
        } else {
            $customer = Customer::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $num,
                'state' => $row['state'],
                'country' => $row['country'],
                'address' => $row['address'],
                'lga' => $row['lga'],
                'agent_id' => $agent->id,
                'org_id' => $agent->org_id,
            ]);

            Customer::where('id', '=', $customer->id)->update([
                'org_id' => Auth::user()->organization_id,
            ]);
            $agent_customer = DB::table('agent_customer')->insert([
                'agent_id' => $agent->id,
                'customer_id' => $customer->id
            ]);

            return $customer;
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
