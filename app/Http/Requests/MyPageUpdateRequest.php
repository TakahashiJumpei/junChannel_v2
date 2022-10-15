<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MyPageUpdateRequest extends FormRequest
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
            'userId' => 'required|integer',
            'nickname' => 'max:20|string|nullable ',
            'email' => 'required|email|unique:users,email,'.Auth::guard('user')->user()->email.',email|string',
        ];
    }

    public function messages()
    {
    return [
        'userId.required' => 'フォームに不正なデータが存在します。',
        'userId.integer' => 'フォームに不正なデータが存在します。',
        'nickname.max' => 'ニックネームは20文字以内にして下さい。',
        'nickname.string'  => '正しい形式で入力してください。',
        'email.required' => 'メールアドレスは必ず入力して下さい。',
        'email.email'  => 'メールアドレスの形式で入力してください。',
        'email.unique'  => 'このメールアドレスは既に登録されています。',
        'email.string'  => '正しい形式で入力してください。',
    ];
    }
}
