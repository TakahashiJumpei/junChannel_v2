@extends('layout.app')

@section('title', 'カテゴリ内スレッド検索 - ' . config("app.name"))
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
                        <a class="card-title font-weight-bold h3 text-dark"
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
                                'class' => 'form-inline ml-lg-3 my-2 my-lg-0',
                            ]) !!}
                            {!! Form::hidden('categoryId', $category->id) !!}
                            {!! Form::search('q', $q ?? '', [
                                'class' => 'form-control mr-2 category-search',
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
        {{-- 検索条件 --}}
        <div class="h3 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title font-weight-bold mb-4 condition-title"><span>スレッドの検索結果</span></h3>
                    <h4 class="font-weight-bold condition-category"><span>検索カテゴリ：{{ $category->name }}</span>
                    </h4>
                    <h4 class="font-weight-bold condition-str"><span>検索文字列：「{{ $q }}」</span></h4>
                    @if ($concatenated_threads_count > 0)
                        <h4 class="font-weight-bold condition-result">
                            <span>{{ $concatenated_threads_count }}件ヒットしました。</span>
                        </h4>
                    @else
                        <h4 class="font-weight-bold condition-result"><span>検索条件に合致するスレッドは見つかりませんでした。</span></h4>
                    @endif
                </div>
            </div>
        </div>

        @if ($concatenated_threads)
            <div class="mt-4 mb-4">
                <table class="table">
                    <thead class="table-bordered table-sm thead-light">
                        <tr>
                            <th colspan="1">
                                ヒットしたスレッド一覧
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered table-sm">
                        @foreach ($concatenated_threads as $concatenated_thread)
                            <tr>
                                {{-- 所属するカテゴリも表示させる --}}
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ml-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('thread/show', $concatenated_thread->id) }}"
                                                class="btn btn-link">{{ $concatenated_thread->name }}</a>
                                        </div>
                                        <div>
                                            @if (isset($concatenated_thread->count_comment))
                                                <span class="ml-2">（{{ $concatenated_thread->count_comment }}件）</span>
                                            @else
                                                <span class="ml-2">（0件）</span>
                                            @endif
                                            @if (isset($concatenated_thread->recently_comment_datetime))
                                                <span class="ml-2">
                                                    {{ $concatenated_thread->recently_comment_datetime->format('m月d日 H:i') }}
                                                </span>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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

            .condition-title {
                font-size: 20px !important;
            }
            .condition-category {
                font-size: 16px !important;
            }
            .condition-str {
                font-size: 16px !important;
            }
            .condition-result {
                font-size: 16px !important;
            }

        }
    </style>

@endsection
