<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEditRequest extends FormRequest
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
            'title' => 'required|max:250',
            'description' => 'required|max:250'
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "max" => "250文字以内で入力してください。"
        ];
    }
}
