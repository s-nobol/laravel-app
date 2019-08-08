<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImageRequest extends FormRequest
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
            //
            'image' => 'file|image|max:5000', //5Mバイト以下
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "file" => "ファイルがありません",
        "image" => "画像ファイルがありません",
        "max" => "画像ファイルが大きすぎます" 
        ];
    }
}
