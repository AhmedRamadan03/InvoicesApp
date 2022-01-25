<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'due_Date',
        'product',
        'cat_id',
        'amount_collection',
        'amount_Commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'note',
        'status',
        'value_status',
        'user',
    ];

    protected $dates = ['deletd_at'];
    public function categories()
    {
        return $this->belongsTo(categories::class, 'cat_id');
    }
}
