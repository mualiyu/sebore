<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class UpdateAgentCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();

        foreach ($customers as $c) {

            DB::table('agent_customer')->insert([
                'agent_id' => $c->agent_id,
                'customer_id' => $c->id
            ]);
        }
    }
}
