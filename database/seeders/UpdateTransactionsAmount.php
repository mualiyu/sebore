<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemsCart;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsAmount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::where('org_id', '=', 7)->get();

        foreach ($transactions as $t) {
            $item = ItemsCart::find(8);
            $amount = $item->measure * $t->quantity;

            DB::table('transactions')->where('id', '=', $t->id)->update([
                'amount' => $amount,
            ]);
        }
    }
}
