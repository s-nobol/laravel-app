<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'address' => 'required',
            'message' => 'required|max',
            'sex' => 'required',
            'birthday' => 'required',
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "max" => "250文字以内で入力してください。"
        ];
    }
}
