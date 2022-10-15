<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Hankaku;

class SignUpRequest extends FormRequest
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
            'nickname' => 'max:20|string|nullable ',
            'email' => 'required|email|unique:users,email|string',
            'password' => ['required', 'min:8', 'max:20', 'string', new Hankaku, 'confirmed'],
            //'passwordConfirm' => ['required', 'min:8', 'max:20', 'string', new Hankaku],
        ];
    }


    //バリデーションのエラー文はデフォルトで英語なので、日本語を設定しておく。
    public function messages()
    {
    return [
        'email.required' => 'メールアドレスは必ず入力して下さい。',
        'email.email'  => 'メールアドレスの形式で入力してください。',
        'email.unique'  => 'このメールアドレスは既に登録されています。',
        'email.string'  => '正しい形式で入力してください。',
        'password.required' => 'パスワードは必ず入力して下さい。',
        'password.min' => 'パスワードは8文字以上にして下さい。',
        'password.max' => 'パスワードは20文字以内にして下さい。',
        'password.string' => '正しい形式で入力してください。',
        'password.confirmed' => 'パスワードが確認入力と一致していません。',
        'nickname.max' => 'ニックネームは20文字以内にして下さい。',
        'nickname.string'  => '正しい形式で入力してください。',
    ];
    }
}
