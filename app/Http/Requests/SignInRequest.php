<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Hankaku;

class SignInRequest extends FormRequest
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
            'email' => 'required|email|string',
            'password' => ['required', 'min:8', 'max:20', 'string', new Hankaku],
        ];
    }


    //バリデーションのエラー文はデフォルトで英語なので、日本語を設定しておく。
    public function messages()
    {
    return [
        'email.required' => 'メールアドレスは必ず入力して下さい。',
        'email.email'  => 'メールアドレス、またはパスワードが違います。',
        'email.string'  => 'メールアドレス、またはパスワードが違います。',
        'password.required' => 'パスワードは必ず入力して下さい。',
        'password.min' => 'メールアドレス、またはパスワードが違います。',
        'password.max' => 'メールアドレス、またはパスワードが違います。',
        'password.string' => 'メールアドレス、またはパスワードが違います。',
    ];
    }
}
