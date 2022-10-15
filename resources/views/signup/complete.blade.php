@extends('layout.app')

@section('title', '会員登録完了 - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <div class="mt-5 mb-5 d-flex justify-content-center">
            <div style="width:640px;">
                <div class="d-flex flex-column align-items-center">
                    <div class="h3 mt-3 mb-3">会員登録完了</div>
                    @if ($nickname != '')
                        <div class="mt-3 mb-5">
                            <span>{{ $nickname }}様、ご登録ありがとうございました。</span>
                        </div>
                    @else
                        <div class="mt-3 mb-3">
                            <span>{{ $email }}様、ご登録ありがとうございました。</span>
                        </div>
                    @endif
                    <div>
                        <a href="{{ url('top') }}" class="btn btn-dark top">トップへ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        input {
            width: 300px !important;
        }

        label {
            width: 300px !important;
            margin-bottom: 0px !important;
        }

        .top {
            width: 150px !important;
        }
    </style>
@endsection
