<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;


class products extends Model
{
protected $fillable = [
        'product_name',
        'department',
        'description',
        'count',
        'price',
        'image',
    ];
    

    public function invoice_items() :hasMany
    {
        return $this->hasMany(invoice_items::class);
    }


}


