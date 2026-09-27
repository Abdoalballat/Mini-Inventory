<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class invoice_items_validate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_id'=>'integer',
            'product_id'=>'required|integer',
            'quantity'=>'required|integer',
            'product_price'=>'required|numeric'
            ,'total_price'=>'numeric',
            'created_at'
        ];
    }
}
