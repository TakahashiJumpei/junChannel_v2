<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
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
      'name' => 'required|max:30|string',
      'categoryId' => 'required',
      'explanation' => 'max:1000|string|nullable',
    ];
  }

  //バリデーションのエラー文はデフォルトで英語なので、日本語を設定しておく。
  public function messages()
  {
    return [
      'name.required' => 'スレッド名は必ず入力して下さい。',
      'name.max'  => 'スレッド名は30文字以内で入力して下さい。',
      'name.string'  => '正しい形式で入力してください。',
      'categoryId.required' => 'カテゴリは必ず選択して下さい。',
      'explanation.max' => 'スレッドの説明は1000文字以内で入力して下さい。',
      'explanation.string' => '正しい形式で入力してください。',
    ];
  }
}
