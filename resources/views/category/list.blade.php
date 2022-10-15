@extends('layout.app')

@section('title', 'カテゴリ一覧 - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')

    <div class="col-12">
        <div class="mt-5 mb-5">

            <div class="d-none d-sm-block">
                <div class="h4">カテゴリ一覧</div>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-sm-6 col-lg-4">
                            <span class="ml-2">[{{ $loop->index + 1 }}]</span>
                            <a href="{{ url('category/show', $category->id) }}" class="btn btn-link">{{ $category->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <table class="table d-sm-none">
                <thead class="table-bordered table-sm thead-light">
                    <tr>
                        <th colspan="1">
                            カテゴリ一覧
                        </th>
                    </tr>
                </thead>
                <tbody class="table-bordered table-sm">
                    @if ($categories)
                        @foreach ($categories as $category)
                            <tr>
                                <td class="d-flex justify-content-start align-items-center">
                                    <div>
                                        <span class="ml-2">[{{ $loop->index + 1 }}]</span>
                                    </div>
                                    <div class="d-md-flex justify-content-start align-items-center">
                                        <div>
                                            <a href="{{ url('category/show', $category->id) }}"
                                                class="btn btn-link">{{ $category->name }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>

    <style>
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
