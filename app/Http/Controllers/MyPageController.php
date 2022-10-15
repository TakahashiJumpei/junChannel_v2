<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\MyPageUpdateRequest;

class MyPageController extends Controller
{
  public function show($userId)
  {
    $user = User::find($userId);

    //DBから作成したスレッド一覧の取得
    //スレッドテーブルから作成したユーザIDに引っかかるスレッドのみを抽出
    $created_threads = Thread::where('creater_id', $userId)->get();
    if ($created_threads->isEmpty()) {
      $created_threads = null;
    } else {
      //各スレッドごとのコメント数を取得。スレッドに紐づいているコメントをすべて取得
      foreach ($created_threads as $created_thread) {
        $count_comment = Comment::where('thread_id', $created_thread->id)->get();
        Log::info('$count_comment', [$count_comment]);
        if ($count_comment->isEmpty()) {
          $created_thread->count_comment = 0;
          $created_thread->recently_comment_datetime = null;
        } else {
          $created_thread->count_comment = count($count_comment);
          $recently_comment_datetime = Comment::orderBy('id', 'DESC')->where('thread_id', $created_thread->id)->first();
          Log::info('$recently_comment_datetime', [$recently_comment_datetime]);
          $created_thread->recently_comment_datetime = $recently_comment_datetime->created_at;
        }
        //各スレッドに対してカテゴリ名を紐づける
        $category = Category::where('id', $created_thread->category_id)->first();
        $created_thread->category_name = $category->name;
      }
    }

    //DBからコメントしたスレッド一覧の取得
    $my_comments = Comment::where('commenter_id', $userId)->groupBy('thread_id')->get();
    Log::info('$my_comments', [$my_comments]);
    if ($my_comments->isEmpty()) {
      $my_comments = null;
      $commented_threads = null;
    } else {
      $thread_ids = array();
      foreach ($my_comments as $my_comment) {
        Log::info('$my_comment->thread_id', [$my_comment->thread_id]);
        $thread_ids[] = $my_comment->thread_id;
      }
      $commented_threads = Thread::whereIn('id', $thread_ids)->get();

      //各スレッドごとのコメント数を取得。スレッドに紐づいているコメントをすべて取得
      foreach ($commented_threads as $commented_thread) {
        $count_comment = Comment::where('thread_id', $commented_thread->id)->get();
        Log::info('$count_comment', [$count_comment]);
        $commented_thread->count_comment = count($count_comment);

        $recently_comment_datetime = Comment::orderBy('id', 'DESC')->where('thread_id', $commented_thread->id)->first();
        Log::info('$recently_comment_datetime', [$recently_comment_datetime]);
        $commented_thread->recently_comment_datetime = $recently_comment_datetime->created_at;

        //各スレッドに対してカテゴリ名を紐づける
        $category = Category::where('id', $commented_thread->category_id)->first();
        $commented_thread->category_name = $category->name;
      }
      //dd($recently_commented_threads);
    }

    //DBからお気に入りしたスレッド一覧の取得
    //先にモデルを作る
    //$created_threads = Thread::where('creater_id' , $userId)->get();
    $favorited_threads = null;

    return view('my_page.show', compact('user', 'created_threads', 'commented_threads', 'favorited_threads'));
  }

  public function edit($userId)
  {
    $user = User::find($userId);
    return view('my_page.edit', compact('user'));
  }

  public function update(MyPageUpdateRequest $request)
  {
    $validatedRequest = $request->validated();
    $user = User::find($validatedRequest['userId']);
    $user->email = $validatedRequest['email'];
    $user->nickname = $validatedRequest['nickname'];
    $user->save();
    return redirect()->route('my_page.show', ['userId' => $user->id]);
  }
}
