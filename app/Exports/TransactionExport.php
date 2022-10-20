<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class TransactionExport implements FromCollection //WithMapping
{
    // public function headings(): array
    // {
    //     return [
    //         '#',
    //         'User',
    //         'Date',
    //     ];
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $transactions = Transaction::all();
        // $tt = [];
        // foreach ($transactions as $t) {
        //     $t->customer;
        //     array_push($tt, $t->customer);
        // }

        return $transactions;
    }

    // /**
    //  * @param Transaction $transaction
    //  *
    //  * @return array
    //  */
    // public function map($transaction): array
    // {
    //     return [
    //         $transaction->customer->name,
    //         $transaction->customer->email,
    //         Date::dateTimeToExcel($transaction->created_at),
    //     ];
    // }
}
