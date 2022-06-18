<?php

namespace App\Http\Controllers;

use App\Models\SaleTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_id' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sale_transaction = SaleTransaction::where('ref_id', '=', $request->ref_id)->update([
            'status' => 1,
        ]);

        if ($sale_transaction) {
            return back()->with('success', "Payment for transaction with reference number " . $request->ref_id . " has been confirmed, Thank you.");
        } else {
            return back()->with('error', "Failed to confirm payment for transaction " . $request->ref_id . ", try again. Thank you...");
        }
    }

    public function update_outstanding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_id' => ['required'],
            'amount' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sale_transaction = SaleTransaction::where('ref_id', '=', $request->ref_id)->get();

        if ($request->amount <= $sale_transaction[0]->dept_amount) {
            $dept_amount = $sale_transaction[0]->dept_amount;
            $paid_amount = $sale_transaction[0]->paid_amount;

            $new_dept_amount = $dept_amount - $request->amount;
            $new_paid_amount = $paid_amount + $request->amount;

            $sale_transaction_update = SaleTransaction::where('ref_id', '=', $request->ref_id)->update([
                'dept_amount' => $new_dept_amount,
                'paid_amount' => $new_paid_amount,
            ]);

            if ($sale_transaction_update) {
                return back()->with('success', 'You have updated the outstanding balance for transaction(' . $request->ref_id . '), Thank you...');
            } else {
                return back()->with('error', 'Failed to updated the outstanding balance for transaction(' . $request->ref_id . ').');
            }
        } else {
            return back()->with('error', "The amount you're willing to add must be less than or equal to the outstanding balance. Try again, Thank you...");
        }
    }
}
