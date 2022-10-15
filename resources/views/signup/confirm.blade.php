@extends('layout.app')

@section('title', '会員登録 - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <div class="mt-5 mb-5 d-flex justify-content-center">
            <div style="width:640px;">
                <div class="d-flex flex-column align-items-center">

                    <div class="h3 mt-3 mb-3">会員登録　入力内容確認</div>
                    <div class="mt-3 mb-5">
                        <span>入力した内容に問題なければ、「登録」ボタンを押してください。</span>
                    </div>
                    {!! Form::open(['url' => '/signup/create', 'method' => 'post', 'files' => true]) !!}
                    {!! Form::token() !!}
                    <div class="form-group">
                        {!! Form::label('inputNickname', 'ニックネーム（任意）') !!}
                        {!! Form::text('nickname', $nickname, [
                            'class' => 'form-control',
                            'id' => 'inputNickname',
                            'placeholder' => 'ニックネーム（任意）',
                            'readonly',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputMailAddress', 'メールアドレス') !!}
                        {!! Form::text('email', $email, [
                            'class' => 'form-control',
                            'id' => 'inputMailAddress',
                            'placeholder' => 'メールアドレス',
                            'readonly',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputPassword', 'パスワード') !!}
                        <input type="password" id="inputPassword" name="password" class="form-control" readonly
                            value='{{ $password }}'>
                    </div>
                    {!! Form::hidden('password_confirmation', $password) !!}
                    <div class="form-button">
                        {!! Form::submit('登録', ['name' => 'action', 'class' => 'btn btn-primary mt-3']) !!}
                    </div>
                    <div class="form-button">
                        {!! Form::submit('修正', ['name' => 'action', 'class' => 'btn btn-secondary mt-3 back']) !!}
                    </div>
                    {!! Form::close() !!}
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

        .back {
            width: 300px !important;
        }

        @media screen and (max-width:320px) {

            .form-group input {
                width: 250px !important;
                margin: 0 auto;
            }

            .form-group label {
                width: 250px !important;
                margin: 0 auto;
                margin-bottom: 0px !important;
            }

            .form-button input {
                width: 250px !important;
                margin: 0 auto;
            }

            .form-button .back {
                width: 250px !important;
                margin: 0 auto;
                margin-bottom: 0px !important;
            }

        }
    </style>
@endsection
