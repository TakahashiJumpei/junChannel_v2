@extends('layout.app')

@section('title', 'ログイン - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <div class="mt-5 mb-5 d-flex justify-content-center">
            <div style="width:640px;">
                <div class="d-flex flex-column align-items-center">
                    <div class="h3 mt-3 mb-3">メールアドレスでログイン</div>
                    {{-- ログインが必要な画面に遷移しようとした際のメッセージ --}}
                    @if (!empty($authRequired))
                        <div class="mb-3">
                            <span class="text-danger">この先はログインが必要です</span>
                        </div>
                    @endif
                    {{-- ログイン失敗もしくはログインバリデーション失敗時のエラー --}}
                    @if ($errors->any() || !empty($signinError))
                        <div class="mb-3">
                            <span class="text-danger">メールアドレス、またはパスワードが違います。</span>
                        </div>
                    @endif
                    {!! Form::open(['url' => '/signin', 'method' => 'post', 'files' => true]) !!}
                    {!! Form::token() !!}
                    <div class="form-group">
                        {!! Form::label('inputMailAddress', 'メールアドレス') !!}
                        {!! Form::text('email', old('email'), [
                            'class' => 'form-control',
                            'id' => 'inputMailAddress',
                            'placeholder' => 'メールアドレス',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputPassword', 'パスワード') !!}
                        {!! Form::password('password', [
                            'class' => 'form-control',
                            'id' => 'inputPassword',
                            'placeholder' => 'パスワード',
                        ]) !!}
                    </div>
                    {!! Form::submit('ログイン', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                    <div class="mt-5">
                        <span>アカウントをお持ちでない方</span>
                        <div class="d-flex justify-content-center mt-1">
                            <a href="{{ url('signup') }}" class="btn btn-dark">新規会員登録</a>
                        </div>
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
            margin-bottom: 0px !important;
        }

        @media screen and (max-width:320px) {

            input {
                width: 250px !important;
            }

            label {
                width: 250px !important;
                margin-bottom: 0px !important;
            }

        }
    </style>
@endsection
