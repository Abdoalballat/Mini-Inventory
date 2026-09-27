<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class invoice_items extends Model
{

        protected $fillable =[
            'invoice_id',
            'product_id',
            'quantity',
            'product_price'
            ,'total_price',
            'created_at'
        ];
    

    public function products():BelongsTo
    {
        return $this->belongsTo(products::class);
    }
    public function invoices():BelongsTo
    {
        return $this->belongsTo(invoices::class);
    }
}
