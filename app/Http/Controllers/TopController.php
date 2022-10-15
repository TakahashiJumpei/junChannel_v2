<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
  public function __invoke()
  {

    //DBから最近作成された最新１０件のスレッドを最新順に取得する
    $recently_created_threads = Thread::orderBy('id', 'DESC')->take(10)->get();
    if ($recently_created_threads->isEmpty()) {
      $recently_created_threads = null;
    } else {
      //各スレッドごとのコメント数を取得。スレッドに紐づいているコメントをすべて取得
      foreach ($recently_created_threads as $recently_created_thread) {
        $count_comment = Comment::where('thread_id', $recently_created_thread->id)->get();
        Log::info('$count_comment', [$count_comment]);
        if ($count_comment->isEmpty()) {
          $recently_created_thread->count_comment = 0;
          $recently_created_thread->recently_comment_datetime = null;
        } else {
          $recently_created_thread->count_comment = count($count_comment);
          $recently_comment_datetime = Comment::orderBy('id', 'DESC')->where('thread_id', $recently_created_thread->id)->first();
          Log::info('$recently_comment_datetime', [$recently_comment_datetime]);
          $recently_created_thread->recently_comment_datetime = $recently_comment_datetime->created_at;
        }
        //各スレッドに対してカテゴリ名を紐づける
        $category = Category::where('id', $recently_created_thread->category_id)->first();
        $recently_created_thread->category_name = $category->name;
      }
      Log::info('$recently_created_threads', [$recently_created_threads]);
    }

    //DBからスレッドを最近コメントされた順にソートして取得
    //まずコメントテーブルからコメントを外部キーであるスレッドテーブルIDが重複しないように１０件取得する。
    //スレッドテーブルが最新のコメント投稿日時順に10種類取得できているので、スレッドをその順番で１０件取得できる。
    $recently_comments = Comment::orderBy('id', 'DESC')->whereIn('id', function ($query) {
      $query->select(DB::raw('MAX(id) As id'))->from('comments')->groupBy('thread_id');
    })->get();
    Log::info('$recently_comments', [$recently_comments]);
    if ($recently_comments->isEmpty()) {
      $recently_comments = null;
      $recently_commented_threads = null;
    } else {
      $thread_ids = array();
      foreach ($recently_comments as $recently_comment) {
        Log::info('$recently_comment->thread_id', [$recently_comment->thread_id]);
        $thread_ids[] = $recently_comment->thread_id;
      }
      $recently_commented_threads = Thread::whereIn('id', $thread_ids)->orderByRaw('FIELD(id, ' . implode(',', $thread_ids) . ')')->take(10)->get();
      Log::info('$recently_commented_threads', [$recently_commented_threads]);

      //各スレッドごとのコメント数を取得。スレッドに紐づいているコメントをすべて取得
      foreach ($recently_commented_threads as $recently_commented_thread) {
        $count_comment = Comment::where('thread_id', $recently_commented_thread->id)->get();
        Log::info('$count_comment', [$count_comment]);
        $recently_commented_thread->count_comment = count($count_comment);

        $recently_comment_datetime = Comment::orderBy('id', 'DESC')->where('thread_id', $recently_commented_thread->id)->first();
        Log::info('$recently_comment_datetime', [$recently_comment_datetime]);
        $recently_commented_thread->recently_comment_datetime = $recently_comment_datetime->created_at;

        //各スレッドに対してカテゴリ名を紐づける
        $category = Category::where('id', $recently_commented_thread->category_id)->first();
        $recently_commented_thread->category_name = $category->name;
      }
      //dd($recently_commented_threads);
    }
    Log::info('$recently_commented_threads', [$recently_commented_threads]);
    //dd($recently_commented_threads);

    //////////////////////////////////////////
    // DBからすべてのカテゴリを取得
    $categories = Category::get();
    if ($categories->isEmpty()) {
      $categories = null;
    }
    Log::info('$categories', [$categories]);

    return view('top', compact('recently_created_threads', 'recently_commented_threads', 'categories'));
  }
}
