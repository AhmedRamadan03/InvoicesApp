<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoices::select('invoice_number','invoice_Date','due_Date','product' ,'cat_id' ,'amount_collection' ,'amount_Commission','value_vat','total' ,'status' ,'payment_date','note')->get();
    }
}
