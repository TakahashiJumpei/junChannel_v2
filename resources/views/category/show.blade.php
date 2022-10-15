@extends('layout.app')

@section('title', $category->name . ' - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')

    @include('layout.categories_list')

    <div class="col-md-9">
        {{-- カテゴリ表題 --}}
        <div class="h3 mt-5 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a class="card-title font-weight-bold h3 text-dark text-decoration-none"
                            href="{{ url('category/show', $category->id) }}">{{ $category->name }}</a>
                        @if ($concatenated_threads_count)
                            <span class="card-text join-category">全{{ $concatenated_threads_count }}件</span>
                        @endif
                    </div>
                    <div class="d-lg-flex justify-content-start align-items-center">
                        {{-- 新規スレッド作成 --}}
                        <a href="{{ url('thread/post', $category->id) }}" class="btn btn-dark">新規スレッド作成</a>
                        {{-- このカテゴリ内のスレッド検索 --}}
                        <div class="d-flex justify-content-start">
                            {!! Form::open([
                                'url' => 'category/search',
                                'method' => 'get',
                                'files' => true,
                                'class' => 'd-flex form-inline ms-lg-3 my-2 my-lg-0',
                            ]) !!}
                            {!! Form::hidden('categoryId', $category->id) !!}
                            {!! Form::search('q', $q ?? '', [
                                'class' => 'form-control me-2 category-search',
                                'placeholder' => 'カテゴリ内スレッド検索',
                            ]) !!}
                            {!! Form::button('検索', [
                                'class' => 'btn btn-dark',
                                'type' => 'submit',
                            ]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- スレッドランキング（勢いのあるスレッド）の表示。コメントが最新のスレッド順に一覧表示 --}}
        <div class="mt-5 mb-5">
            <table class="table">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            スレッド一覧
                        </th>
                    </tr>
                </thead>
                <tbody class="table-bordered table-sm">
                    @if ($concatenated_threads)
                        @foreach ($concatenated_threads as $concatenated_thread)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ms-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $concatenated_thread->id) }}"
                                                class="btn btn-link text-decoration-none">{{ $concatenated_thread->name }}</a>
                                        </div>
                                        <div>
                                            @if (isset($concatenated_thread->count_comment))
                                                <span class="ms-2">（{{ $concatenated_thread->count_comment }}件）</span>
                                            @else
                                                <span class="ms-2">（0件）</span>
                                            @endif
                                            @if (isset($concatenated_thread->recently_comment_datetime))
                                                <span class="ms-2">
                                                    {{ $concatenated_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                                </span>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                このカテゴリに属するスレッドはありません。
                                <br>
                                スレッドを作成してみよう！
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .join-category {
            font-size: 16px;
        }

        a.text-dark:hover {
            color: #ccc !important;
            text-decoration: none;
        }

        table {
            table-layout: fixed;
            width: 100%;
            word-break: break-all;
            word-wrap: break-all;
        }

        tr {
            background-color: white;
        }

        input.category-search {
            width: 350px !important;
        }

        @media screen and (max-width:550px) {

            input.category-search {
                width: 300px !important;
            }
        }

        @media screen and (max-width:450px) {

            input.category-search {
                width: 200px !important;
            }

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
