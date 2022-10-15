<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
  public function __invoke(Request $request)
  {

    // DBからすべてのカテゴリを取得
    $categories = Category::get();
    if ($categories->isEmpty()) {
      $categories = null;
    }
    Log::info('$categories', [$categories]);


    //入力した文字列に部分一致で引っかかるスレッドを取得
    Log::info('$request->str', [$request->str]);
    $str = $request->str;

    //DBからスレッドを最近コメントされた順にソートして取得
    //まずコメントテーブルからコメントを外部キーであるスレッドテーブルIDが重複しないように１０件取得する。
    //スレッドテーブルが最新のコメント投稿日時順に10種類取得できているので、スレッドをその順番で１０件取得できる。
    $recently_comments = Comment::orderBy('id', 'DESC')->whereIn('id', function ($query) {
      $query->select(DB::raw('MAX(id) As id'))->from('comments')->groupBy('thread_id');
    })->get();
    Log::info('$recently_comments', [$recently_comments]);

    $thread_ids = array();
    foreach ($recently_comments as $recently_comment) {
      Log::info('$recently_comment->thread_id', [$recently_comment->thread_id]);
      $thread_ids[] = $recently_comment->thread_id;
    }
    $recently_commented_threads = Thread::where('name', 'like', "%$str%")->whereIn('id', $thread_ids)->orderByRaw('FIELD(id, ' . implode(',', $thread_ids) . ')')->take(10)->get();
    Log::info('$recently_commented_threads', [$recently_commented_threads]);
    $recently_commented_threads_count = Thread::where('name', 'like', "%$str%")->whereIn('id', $thread_ids)->orderByRaw('FIELD(id, ' . implode(',', $thread_ids) . ')')->take(10)->get()->count();
    Log::info('$recently_commented_threads_count', [$recently_commented_threads_count]);

    //各スレッドごとのコメント数を取得。スレッドに紐づいているコメントをすべて取得
    foreach ($recently_commented_threads as $recently_commented_thread) {
      $count_comment = Comment::where('thread_id', $recently_commented_thread->id)->get();
      Log::info('$count_comment', [$count_comment]);
      $recently_commented_thread->count_comment = count($count_comment);

      $recently_comment_datetime = Comment::orderBy('id', 'DESC')->where('thread_id', $recently_commented_thread->id)->first();
      Log::info('$recently_comment_datetime', [$recently_comment_datetime]);
      $recently_commented_thread->recently_comment_datetime = $recently_comment_datetime->created_at;
    }
    Log::info('$recently_commented_threads', [$recently_commented_threads]);
    Log::info('bbb');
    $flag = 0;
    if ($recently_commented_threads->isEmpty()) {
      $flag++;
    }
    Log::info('$flag', [$flag]);

    //ここまででコメントがなされている検索条件に合うスレッド一覧が取得できた
    //ここからはコメントされていないかつ検索条件に合うスレッド一覧をスレッド作成順に取得する
    //上記で取得済みのスレッドIDは除外する
    $recently_commented_thread_ids = array();
    foreach ($recently_commented_threads as $recently_commented_thread) {
      Log::info('$recently_commented_thread->id', [$recently_commented_thread->id]);
      $recently_commented_thread_ids[] = $recently_commented_thread->id;
    }
    $no_comment_recently_created_threads = Thread::orderBy('id', 'DESC')->where('name', 'like', "%$str%")->whereNotIn('id', $recently_commented_thread_ids)->get();
    $no_comment_recently_created_threads_count = Thread::orderBy('id', 'DESC')->where('name', 'like', "%$str%")->whereNotIn('id', $recently_commented_thread_ids)->get()->count();
    Log::info('$no_comment_recently_created_threads', [$no_comment_recently_created_threads]);
    Log::info('$no_comment_recently_created_threads_count', [$no_comment_recently_created_threads_count]);
    Log::info('$flag', [$flag]);
    if ($no_comment_recently_created_threads->isEmpty()) {
      $flag++;
    }
    Log::info('$flag', [$flag]);

    if ($flag == 2) {
      Log::info('$flag == 2');
      $concatenated_threads = null;
      $concatenated_threads_count = null;
    } else {
      Log::info('$flag != 2');
      //２つの内容を合体させる
      $concatenated_threads = $recently_commented_threads->concat($no_comment_recently_created_threads);
      Log::info('$concatenated_threads', [$concatenated_threads]);
      $concatenated_threads_count = $recently_commented_threads_count + $no_comment_recently_created_threads_count;
      Log::info('$concatenated_threads_count', [$concatenated_threads_count]);
    }

    return view('search.search', compact('str', 'categories', 'concatenated_threads', 'concatenated_threads_count'));
  }
}
