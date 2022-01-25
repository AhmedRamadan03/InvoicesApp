<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    // protected $quarded = [];

    protected $fillable = [
        'product_name',
        // 'cat_name',
        'description',
        'cat_id'
    ];
    public function categories()
    {
        return $this->belongsTo(categories::class, 'cat_id');
    }
}
