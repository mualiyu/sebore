<?php

namespace Database\Seeders;

use App\Models\Item;
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
        $transactions = Transaction::all();

        foreach ($transactions as $t) {
            $item = Item::find($t->item_id);
            $amount = $item->item_cart->measure * $t->quantity;

            DB::table('transactions')->where('id', '=', $t->id)->update([
                'amount' => $amount,
            ]);
        }
    }
}
