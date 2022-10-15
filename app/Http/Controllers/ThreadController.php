<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use App\Models\Comment;
use App\Models\Guest;
use App\Http\Requests\ThreadRequest;
use App\Http\Requests\CommentRequest;

use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
  public function show($threadId)
  {
    $thread = Thread::find($threadId);
    Log::info('$thread', [$thread]);

    //ユーザテーブルから表示中のスレッドIDに引っかかるユーザのみを抽出
    $category = Category::where('id', $thread->category_id)->first();
    Log::info('$category', [$category]);
    $categoryId = $thread->category_id;

    //ユーザテーブルから表示中のスレッドIDに引っかかるユーザのみを抽出
    $created_user = User::where('id', $thread->creater_id)->first();
    Log::info('$created_user', [$created_user]);

    //ログイン中のユーザを取得
    $user = Auth::guard('user')->user();
    Log::info('$user', [$user]);
    //dd($user);

    //このスレッドに紐づいているコメントをすべて取得
    $comments = Comment::where('thread_id', $thread->id)->get();
    $comment_count = Comment::where('thread_id', $thread->id)->get()->count();
    Log::info('$comments', [$comments]);
    Log::info('$comment_count', [$comment_count]);
    //dd($comment_count);

    if ($comments->isEmpty()) {
      Log::info('$commentsは空です');
      $comments = null;
    } else {
      Log::info('$commentsは空ではありません');
      //このコメントオブジェクトに、コメントした人のニックネームを追加したい
      foreach ($comments as $comment) {
        Log::info('$comment->commenter_id', [$comment->commenter_id]);
        //コメントIDからユーザのニックネームを取得する
        $commenter = User::where('id', $comment->commenter_id)->first();
        Log::info('$commenter', [$commenter]);
        Log::info('$commenter', [$commenter->nickname]);
        //そのユーザのニックネームをコメントオブジェクトに追加する
        $comment->commenter_nickname = $commenter->nickname;
      }
    }

    // DBからすべてのカテゴリを取得
    $categories = Category::get();
    if ($categories->isEmpty()) {
      $categories = null;
    }
    Log::info('$categories', [$categories]);

    return view('thread.show', compact('categoryId', 'thread', 'category', 'created_user', 'user', 'comments', 'comment_count', 'categories'));
  }

  public function post($categoryId = null)
  {
    $categories = Category::query()->orderBy('id')->pluck('name', 'id');
    Log::info('$categories', [$categories]);

    return view('thread.post', compact('categories', 'categoryId'));
  }

  public function create(ThreadRequest $request)
  {
    //DBにスレッドを登録
    /**
     * スレッドid
     * 作成ユーザー
     * スレッド名
     * 属するカテゴリid
     * 作成日時
     * 更新日時
     * 更新理由
     */
    $validatedRequest = $request->validated();
    $data = [
      'createrId' => $request['createrId'],
      'name' => $validatedRequest['name'],
      'explanation' => $validatedRequest['explanation'],
      'categoryId' => $validatedRequest['categoryId'],
    ];
    Log::info('スレッド作成時のリクエストパラメータ：', $data);
    //dd($data);
    $thread = Thread::create([
      'creater_id' => $request['createrId'],
      'name' => $validatedRequest['name'],
      'explanation' => $validatedRequest['explanation'],
      'category_id' => $validatedRequest['categoryId'],
    ]);
    Log::info('$thread', [$thread]);
    return redirect()->route('thread.show', $thread);
    // return redirect()->route('thread.show', ['threadId' => $thread->id]);
  }

  public function commentPost(CommentRequest $request)
  {
    //コメント欄で空で入力した際にDBエラーとなるのでバリデーションする
    //$validatedRequest = $request->validated();
    /**
     * スレッドにコメントを投稿
     * コメントテーブルにコメントを新規追加する処理
     * ・投稿者ID
     * ・ゲストID
     * ・スレッドID
     * ・コメントナンバー
     * ・コメント内容
     * ・投稿日時
     * ・更新日時
     */
    //ログイン中のユーザを取得
    $user = Auth::guard('user')->user();
    Log::info('$user', [$user]);
    //ログイン中の場合、そのユーザとして投稿する
    //未ログインの場合、ゲストとして投稿する
    if ($user) {
      //以下はログイン済みユーザ向けのリクエストボディ
      $data = [
        'commenter_id' => $request['userId'],
        'guests_commenter_id' => "notGuest",
        'thread_id' => $request['thread_id'],
        'comment_number' => $request['comment_number'],
        'content' => $request['content'],
      ];
      Log::info('コメント投稿時のリクエストパラメータ（ログイン済みユーザ向け）：', $data);

      $comment = Comment::create([
        'commenter_id' => $request['userId'],
        'guests_commenter_id' => "notGuest",
        'thread_id' => $request['thread_id'],
        'comment_number' => $request['comment_number'],
        'content' => $request['content'],
      ]);
      Log::info('$comment', [$comment]);

      $threadId = $request['thread_id'];
      return redirect()->route('thread.show', $threadId);
    } else {
      //クッキーからゲスト用keyを取得して、そのkeyでゲストテーブルからゲストIDを取得する。
      //クッキーからゲスト用keyを取得できなかった場合は、別のゲストとみなし、新しいゲストkeyを発行して、ゲストテーブルに新しいゲストを追加する。
      //コメント投稿成功後に利用ユーザのPCのクッキーに保存させる。
      //次回のコメントからはそのゲストkeyを取得してゲストIDを取得し、コメントさせる。
      $guest_user = null;
      if ($request->hasCookie('identify_key')) {
        Log::info('クッキーを持っているユーザー');
        $identify_key = $request->cookie('identify_key');
        //ゲストテーブルからゲスト用keyに引っかかるゲストIDを抽出
        $guest_user = Guest::where('identify_key', $identify_key)->first();
        Log::info('$guest_user', [$guest_user]);
      } else {
        Log::info('クッキーを持っていないユーザー');
        //別のゲストとみなし、新しいゲストkeyを発行して、ゲストテーブルに新しいゲストを追加する。
        for ($i = 0; $i < 5; $i++) {
          $identify_key = randomSring(36); //ランダム文字列生成
          $exists = Guest::where('identify_key', $identify_key)->exists(); //被ってはいけないのでDBに存在チェック
          if (!$exists) {
            $guest_user = Guest::create([
              'identify_key' => $identify_key,
            ]);
            Log::info('$guest_user', [$guest_user]);
            break;
          }
          if ($i === 4) {
            Log::alert('正しくゲストが作成できませんでした');
            throw new \Exception('正しくゲストが作成できませんでした');
          }
        }
        //ゲストテーブルからゲスト用keyに引っかかるゲストIDを抽出
        $guest_user = Guest::where('identify_key', $identify_key)->first();
        Log::info('$guest_user', [$guest_user]);
      }
      $data = [
        'commenter_id' => 1, //ゲスト用のユーザID
        'guests_commenter_id' => $guest_user->identify_key, //ゲスト用key
        'thread_id' => $request['thread_id'],
        'comment_number' => $request['comment_number'],
        'content' => $request['content'],
      ];
      Log::info('コメント投稿時のリクエストパラメータ（ゲストユーザ向け）：', $data);

      $comment = Comment::create([
        'commenter_id' => 1, //ゲスト用のユーザID
        'guests_commenter_id' => $guest_user->identify_key, //ゲスト用key
        'thread_id' => $request['thread_id'],
        'comment_number' => $request['comment_number'],
        'content' => $request['content'],
      ]);
      Log::info('$comment', [$comment]);

      $threadId = $request['thread_id'];
      $response = redirect()->route('thread.show', $threadId);
      $response->cookie('identify_key', $identify_key);
      return $response;
    }
  }
}

function randomSring($length)
{
  return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789-'), 0, $length - 1);
}
