@extends('layout.app')

@section('title', 'マイページ - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <h1 class="mt-5 mb-5 mypage-title">
            <span class="text-success">
                @if (!empty($user->nickname))
                    {{ $user->nickname }}
                @else
                    名無し
                @endif
            </span>
            さんのマイページ
        </h1>
        <div class="d-flex flex-column mb-5">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th colspan="2">会員情報</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ニックネーム</td>
                        <td>
                            @if (!empty($user->nickname))
                                {{ $user->nickname }}
                            @else
                                名無し
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>メールアドレス</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    {{-- <tr>
                        <td>アイコン画像</td>
                        <td>{{ $user->icon_image_path }}</td>
                    </tr> --}}
                </tbody>
            </table>
            <div class="d-sm-flex justify-content-end d-none">
                <a href="{{ url('my_page/edit', $user->id) }}" class="btn btn-dark btn-lg">会員情報の編集</a>
            </div>
            <div class="d-flex justify-content-end d-sm-none">
                <a href="{{ url('my_page/edit', $user->id) }}" class="btn btn-dark btn-mg">会員情報の編集</a>
            </div>
        </div>

        <div class="mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            作成したスレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($created_threads)
                        @foreach ($created_threads as $created_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ms-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $created_thread->id) }}"
                                                class="btn btn-link text-decoration-none">{{ $created_thread->name }}</a>
                                        </div>
                                        <div>
                                            <span class="ms-2">（{{ $created_thread->count_comment }}件）</span>
                                            @if (isset($created_thread->recently_comment_datetime))
                                                <span class="ms-2">
                                                    {{ $created_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                                </span>
                                            @else
                                            @endif
                                            <span class="ms-3 td-category">
                                                [ <a
                                                    href="{{ url('category/show', $created_thread->category_id) }}" class="text-decoration-none">{{ $created_thread->category_name }}</a>
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
                                作成したスレッドはありません。
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            コメントしたスレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($commented_threads)
                        @foreach ($commented_threads->unique('id') as $commented_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ms-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $commented_thread->id) }}"
                                                class="btn btn-link text-decoration-none">{{ $commented_thread->name }}</a>
                                        </div>
                                        <div>
                                            <span class="ms-2">（{{ $commented_thread->count_comment }}件）</span>
                                            @if (isset($commented_thread->recently_comment_datetime))
                                                <span class="ms-2">
                                                    {{ $commented_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                                </span>
                                            @else
                                            @endif
                                            <span class="ms-3 td-category">
                                                [ <a
                                                    href="{{ url('category/show', $commented_thread->category_id) }}" class="text-decoration-none">{{ $commented_thread->category_name }}</a>
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
                                コメントしたスレッドはありません。
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- <div class="mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            お気に入りしたスレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($favorited_threads)
                        @foreach ($favorited_threads as $favorited_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div class="ml-2">[{{ $loop->index + 1 }}]</div>
                                    <a href="{{ url('thread/show', $favorited_thread->id) }}"
                                        class="btn btn-link">{{ $favorited_thread->name }}</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                お気に入りしたスレッドはありません。
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div> --}}


    </div>

    <style>
        @media screen and (max-width:450px) {

            .mypage-title {
                font-size: 26px !important;
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
