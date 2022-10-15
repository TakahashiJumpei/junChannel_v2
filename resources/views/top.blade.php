@extends('layout.app')

@section('title', config("app.name"))
@include('layout.header')
@include('layout.footer')


@section('content')

    @include('layout.categories_list')

    <div class="col-lg-9">

        {{-- じゅんちゃんねるの簡単な紹介 --}}
        <div class="h3 mt-5 mb-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold mb-4"><span>じゅんちゃんねるについて</span></h3>
                    <h5 class="card-text">
                        じゅんちゃんねるは某有名掲示板を真似た匿名掲示板です。<br>スレッドでのコメントを通じて趣味が合う者同士（雑談でも何でもOK）の楽しい交流の場として利用していただけると管理人としても嬉しいです。<br>基本的にお好きにご利用いただいて構いませんが、最低限のマナーを守って利用しましょう！
                        </h4>
                </div>
            </div>
        </div>

        {{-- 最近作成されたスレッド一覧の表示 --}}
        {{-- 最近作成された最新１０件のスレッドを最新順に一覧表示する --}}
        <div class="mt-5 mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            最近作成されたスレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody class="table-bordered table-sm">
                    @if ($recently_created_threads)
                        @foreach ($recently_created_threads as $recently_created_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ml-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $recently_created_thread->id) }}"
                                                class="btn btn-link text-decoration-none">{{ $recently_created_thread->name }}</a>
                                        </div>
                                        <div>
                                            <span class="ml-2">（{{ $recently_created_thread->count_comment }}件）</span>
                                            @if (isset($recently_created_thread->recently_comment_datetime))
                                                <span class="ml-2">
                                                    {{ $recently_created_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                                </span>
                                            @else
                                            @endif
                                            <span class="ml-3 td-category">
                                                [ <a
                                                    href="{{ url('category/show', $recently_created_thread->category_id) }}" class="text-decoration-none">{{ $recently_created_thread->category_name }}</a>
                                                ]
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                作成されたスレッドはありません。
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- スレッドランキング（勢いのあるスレッド）の表示。コメントが最新のスレッド順に一覧表示 --}}
        <div class="mt-5 mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            勢いのあるスレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody class="table-bordered table-sm">
                    @if ($recently_commented_threads)
                        @foreach ($recently_commented_threads as $recently_commented_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ml-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $recently_commented_thread->id) }}"
                                                class="btn btn-link text-decoration-none">{{ $recently_commented_thread->name }}</a>
                                        </div>
                                        <div>
                                            <span class="ml-2">（{{ $recently_commented_thread->count_comment }}件）</span>
                                            <span class="ml-2">
                                                {{ $recently_commented_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                            </span>
                                            <span class="ml-3 td-category">
                                                [ <a
                                                    href="{{ url('category/show', $recently_commented_thread->category_id) }}" class="text-decoration-none">{{ $recently_commented_thread->category_name }}</a>
                                                ]
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                勢いのあるスレッドはありません。
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ※必要に応じて「もっと見る」で各種、別画面でもっと多い件数を表示させる --}}

        {{-- カテゴリ一覧の表示 --}}

    </div>

    <style>
        @media screen and (max-width:450px) {

            .card-title {
                font-size: 18px !important;
            }

            .card-text {
                font-size: 14px !important;
            }
        }


        tr {
            background-color: white;
        }

        table {
            table-layout: fixed;
            width: 100%;
            word-break: break-all;
            word-wrap: break-all;
        }

        @media screen and (max-width:450px) {

            table {
                font-size: 12px !important;
            }

            table a {
                font-size: 14px !important;
            }

            table .td-category a {
                font-size: 12px !important;
            }

        }
    </style>

@endsection
