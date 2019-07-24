<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessagesRequest extends FormRequest
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
            'content' => 'required|max:25',
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "email" => "メールアドレスの形式で入力してください。",
        "numeric" => "数値で入力してください。",
        "max" => "25文字以内で入力してください。"
        ];
    }
}
