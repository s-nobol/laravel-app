<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
            'name' => 'required|max:250',
            'sex' => 'required',
            'address' => 'required',
            // 'birthday' => 'required',
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "max" => "250文字以内で入力してください。",
        "unique" => "メールアドレスはすでにしています"
        ];
    }
}
