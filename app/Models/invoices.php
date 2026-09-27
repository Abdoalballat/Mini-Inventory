<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class invoices extends Model
{

        protected $fillable =[
            'total_price','created_at'
        ];
    

    public function invoice_items() :hasMany
    {
        return $this->hasMany(invoice_items::class,'invoice_id');
    }
    
}
