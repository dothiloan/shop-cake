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
            'name' => 'required',
            'unit_price' => 'required',
            'id_type' => 'required',
            'description' => 'required',
            'image' => 'required',

        ];
    }

    public function messages()
    {
        return [
            
            'name.required' => 'Tên sản phẩm không được bỏ trống',
            'unit_price.required'  => 'Giá sản phẩm không được bỏ trống',
            'id_type.required'  => 'Tên danh mục không được bỏ trống',
            'brand_id.required'  => 'Tên thương hiệu không được bỏ trống',
            'description.required'  => 'Mô tả ngắn không được bỏ trống',
            'image.required' => 'Hình ảnh không được bỏ trống',
            
        ];
    }


}
