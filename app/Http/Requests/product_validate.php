<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class product_validate extends FormRequest
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
        'product_name'=> 'required|string|max:50',
        'department'  => 'required|string|max:35',
        'description' =>  'string|max:255',
        'count'       => 'required|integer|min:0',
        'price'       => 'required|numeric|min:0',
        'image'       => 'nullable|image|mimes:png,jpg,jepg,gif|max:2048', 
    ];
}
}
