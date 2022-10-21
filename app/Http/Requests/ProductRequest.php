<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'p_name' => 'required',
            'amount' => 'required',
            'code' => 'required',
            'warehouse_id' => 'required',
            'product_category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'p_name.required' => 'Mahsulot nomini kiriting !',
            'amount.required' => 'Mahsulot miqdorini kiriting !',
            'code.required' => 'Mahsulot kodini kiriting !',
            'product_category_id.required' => 'O\'lchamni tanlang !',
            'warehouse_id.required' => 'Skladni tanlang !',
        ];
    }
}
