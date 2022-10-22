<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class TransactionExport implements WithHeadings, FromCollection //, WithMapping
{
    // public $transactions;
    public $from;
    public $to;
    public $data_d;
    public $type;

    public function __construct($type, $from, $to, $data_d)
    {
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
        $this->data_d = $data_d;
    }

    public function headings(): array
    {
        return [
            '#',
            'Item Name',
            'Measure - unit',
            'Quantity',
            'Total Amount',
            'Transaction Type',
            'Date',
            'Agent',
            'Customer Name',
            'Customer Phone',
            'Community',
            'Status',
            'Bill Ref',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // $transactions = $this->transactions;
        if ($this->type == "all") {
            $transactions = Transaction::where('org_id', '=', Auth::user()->organization_id)->whereBetween('date', [$this->from . '-00-00-00', $this->to . '-23-59-59'])->get();
        }

        $tt = [];
        $i = 1;
        foreach ($transactions as $t) {
            $per_transaction = [];

            $item = \App\Models\Item::find($t->item_id);

            array_push($per_transaction, $i);
            array_push($per_transaction, $item->item_cart->name);
            array_push($per_transaction, $item->item_cart->measure."-".$item->item_cart->unit);
            array_push($per_transaction, $t->quantity);
            array_push($per_transaction, $t->amount);
            array_push($per_transaction, $t->type);
            array_push($per_transaction, $t->date);
            array_push($per_transaction, $t->agent->name);
            array_push($per_transaction, $t->customer->name);
            array_push($per_transaction, $t->customer->phone);
            array_push($per_transaction, $t->device->community);
            array_push($per_transaction, $t->p_status==0 ? "Not Paid":"Paid");
            array_push($per_transaction, $t->ref_id );



            array_push($tt, $per_transaction);
        }

        // dd(collect($tt));
        return collect($tt); 
    }
    

    // public function map($invoice): array
    // {
    //     return [
    //         $invoice->invoice_number,
    //         $invoice->user->name,
    //         Date::dateTimeToExcel($invoice->created_at),
    //     ];
    // }
}
