<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
      'content' => 'required|max:1000|string',
    ];
  }

  //バリデーションのエラー文はデフォルトで英語なので、日本語を設定しておく。
  public function messages()
  {
    return [
      'content.required' => 'コメント内容は必ず入力して下さい。',
      'content.max' => 'コメント内容は1000文字以内で入力して下さい。',
      'content.string' => '正しい形式で入力してください。',
    ];
  }
}
