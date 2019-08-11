<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required|max:50',
            'description' => 'required|max:250'
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "email" => "メールアドレスの形式で入力してください。",
        "numeric" => "数値で入力してください。",
        "title.max" => "50文字以内で入力してください。",
        "description.max" => "250文字以内で入力してください。",
        "file" => "ファイルがありません" ,
        "image" => "画像ファイルではありません",
        "image.max" => "画像ファイルが大きすぎます" 
        ];
    }
}
//  'photo' => 'required|file|mimes:jpg,jpeg,png,gif'
