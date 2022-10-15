@extends('layout.app')

@section('title', $thread->name . ' - ' . config('app.name'))
@include('layout.header')
@include('layout.footer')

@section('content')

    @include('layout.categories_list')

    <div class="col-lg-9">
        {{-- スレッド表題 --}}
        <div class="h3 mt-5 mb-5">
            <div class="card thread-title">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="card-text join-category">カテゴリ：{{ $category->name }}</span>
                        {{-- <button class="btn btn-primary btn-sm">スレッドをお気に入り登録</button> --}}
                    </div>
                    <h3 class="card-title font-weight-bold mt-2 mb-4"><span>{{ $thread->name }}</span></h3>
                    <h4 class="card-text mb-3">{{ $thread->explanation }}</h4>
                    {{-- 作成ユーザ名、作成日時、属するカテゴリ（リンク付き） --}}
                    <h5 class="card-text"><img src="{{ asset('images/person.png') }}" alt="">
                        {{ $created_user->nickname }} ★ {{ $thread->created_at }}</h5>
                </div>
            </div>
        </div>

        {{-- 表示数の設定機能（「全部」、「最新５０件」、「1-100」のページング） --}}
        {{-- 表示中スレッドのコメント数を表示 --}}
        <div class="d-flex justify-content-end align-items-center">
            <h5 class="card-text comment-count">全{{ $comment_count }}件</h5>
        </div>

        {{-- コメント一覧 --}}
        {{-- //コメントが0件の場合 --}}
        {{-- //コメントが１以上の場合 --}}
        {{-- ~各コメント部分~（コメントテーブルから取得）
          ・コメント番号
          ・コメントしたユーザのニックネームの表示（IDした取得できない）
          ・投稿日付時刻の表示
          ・コメント内容
          ・コメント番号押下でそのコメントに対してリプライできるように新規コメントが入力できる（DB未搭載）
          ・いいね、badボタン（DB未搭載）
          ・通報ボタン（コメントしたユーザには非表示）
          ・削除ボタン（管理人とそのコメントをしたユーザだけ） --}}
        <div class="h3 mt-2 mb-3">
            @if ($comments)
                @foreach ($comments as $comment)
                    <div class="card res">
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">
                                {{-- <a href="#" class="mr-3 link-primary">#{{ $comment->comment_number }}</a> --}}
                                {{-- ↑コメント引用機能のための改修をDB側に搭載できれば差し替える --}}
                                <span class="me-3">#{{ $comment->comment_number }}</span>
                                @if ($comment->guests_commenter_id === 'notGuest')
                                    <span class="me-3">{{ $comment->commenter_nickname }}</span>
                                @else
                                    <span class="me-3">名無しさん</span>
                                @endif
                                <span class="me-3">{{ $comment->created_at }}</span>
                                @if ($loop->last)
                                    <span class="font-weight-normal text-secondary">（最新コメント）</span>
                                @endif
                            </h4>
                            <h4 class="card-text mb-3">{{ $comment->content }} </h4>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-text nothing-comment">このスレッドにまだコメントはありません。<br>最初のコメントを投稿してみよう！</h4>
                    </div>
                </div>
            @endif
        </div>

        {{-- 新着コメントを表示ボタン --}}
        <div class="d-sm-flex justify-content-center mt-4 d-none">
            <a href="{{ url('thread/show', $thread->id) }}" class="btn btn-dark btn-lg">新着コメントを表示</a>
        </div>
        <div class="d-flex justify-content-center mt-4 d-sm-none">
            <a href="{{ url('thread/show', $thread->id) }}" class="btn btn-dark btn-md">新着コメントを表示</a>
        </div>


        {{-- コメント投稿欄 --}}
        {{-- ・コメント内容入力フォーム
          ・コメントしたユーザのニックネームの設定
          ・誹謗中傷内容に対する注記
          ・コメント投稿後は、この画面をGETで表示させればOK --}}
        {!! Form::open([url('thread/show', $thread->id), 'method' => 'POST', 'files' => true]) !!}

        @if ($user)
            {!! Form::hidden('userId', $user->id) !!}
        @else
        @endif

        {!! Form::hidden('thread_id', $thread->id) !!}

        @if ($comments)
            {!! Form::hidden('comment_number', count($comments) + 1) !!}
        @else
            {!! Form::hidden('comment_number', 1) !!}
        @endif

        <div class="h3 mt-5 mb-3">
            <div class="card commnet-form">
                <div class="card-body">
                    <p class="card-title font-weight-bold mb-4"><span>コメントを投稿</span></p>
                    @php
                        if (!empty($user->nickname)) {
                            $nickname = $user->nickname;
                        } else {
                            $nickname = '名無し';
                        }
                    @endphp
                    <h5 class="mb-3"><span>投稿時の名前：{{ $nickname }}</span></h5>
                    @if ($errors->any())
                        <div class="error-text mb-1">
                            <span class="text-danger">コメントの投稿に失敗しました。</span>
                        </div>
                    @endif
                    {{-- コメント欄が空入力だった際にエラーメッセージの表示 --}}
                    @error('content')
                        <div class="error-text mb-1">
                            <span class="text-danger">{{ $message }}</span>
                        </div>
                    @enderror
                    {!! Form::textarea('content', null, [
                        'class' => 'form-control',
                        'id' => 'content',
                        'placeholder' => 'コメント内容を入力',
                        'rows' => '5',
                    ]) !!}
                    <div class="d-sm-flex justify-content-center mt-4 d-none">
                        {!! Form::submit('コメントを投稿する', ['class' => 'btn btn-dark btn-lg']) !!}
                    </div>
                    <div class="d-flex justify-content-center mt-4 d-sm-none">
                        {!! Form::submit('コメントを投稿する', ['class' => 'btn btn-dark btn-mg']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <style>
        .join-category {
            font-size: 16px;
        }

        tr {
            background-color: white;
        }

        .error-text {
            font-size: 16px;
        }

        @media screen and (max-width:450px) {

            .thread-title .card-body .card-title {
                font-size: 20px !important;
            }

            .thread-title .card-body .card-text {
                font-size: 17px !important;
            }

            .comment-count {
                font-size: 16px !important;
            }

            .nothing-comment {
                font-size: 14px !important;
            }

            .res .card-body h4 {
                font-size: 16px !important;
            }

            .res .card-body .card-text {
                font-size: 16px !important;
            }

            .commnet-form .card-body .card-title {
                font-size: 20px !important;
            }

            .commnet-form .card-body h5 {
                font-size: 16px !important;
            }


        }
    </style>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        // ページが読み込まれたら実行
        $(() => {
            let top = 0;
            $('.error-text').each((index, element) => {
                let newTop = $(element).parent().offset().top;
                if (top === 0 || top > newTop) {
                    top = newTop;
                }
            });
            $('html, body').animate({
                scrollTop: top
            }, 'fast');
        });
    </script>
@endsection
