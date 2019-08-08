<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserEdit2Request extends FormRequest
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
        // 自分のメールアドレス.
        $user = Auth::user();
        
        return [
            
            'name' => 'required|max:250',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'address' => 'required',
            'message' => 'max:250',
            'sex' => 'required',
            // 'birthday' => 'required',
        ];
    }
    public function messages() {
        return [
        "required" => "必須項目です。",
        "max" => "250文字以内で入力してください。",
        "unique" => "はすでにしています",
        "email" => "メールアドレスが正しくありません"
        ];
    }
}
