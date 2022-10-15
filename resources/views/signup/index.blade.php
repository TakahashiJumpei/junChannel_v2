@extends('layout.app')

@section('title', '会員登録 - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <div class="mt-5 mb-5 d-flex justify-content-center">
            <div style="width:640px;">
                <div class="d-flex flex-column align-items-center">

                    <div class="h3 mt-3 mb-3">会員登録</div>

                    @if (count($errors) > 0)
                        <div class="mb-3">
                            <span class="text-danger">入力に問題があります。再入力して下さい。</span>
                        </div>
                    @endif

                    {!! Form::open(['url' => '/signup', 'method' => 'post', 'files' => true]) !!}
                    {!! Form::token() !!}
                    <div class="form-group">
                        {!! Form::label('inputNickname', 'ニックネーム（任意）') !!}
                        {!! Form::text('nickname', old('nickname'), [
                            'class' => 'form-control',
                            'id' => 'inputNickname',
                            'placeholder' => 'ニックネーム（任意）',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputMailAddress', 'メールアドレス') !!}
                        {!! Form::text('email', old('email'), [
                            'class' => 'form-control',
                            'id' => 'inputMailAddress',
                            'placeholder' => 'メールアドレス',
                        ]) !!}
                        @error('email')
                            <div>
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputPassword', 'パスワード') !!}
                        {{-- {!! Form::password('password', [
                            'class' => 'form-control',
                            'id' => 'inputPassword',
                            'placeholder' => 'パスワード',
                        ]) !!} --}}
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="パスワード"
                            value='{{ old('password') }}'>
                        @error('password')
                            <div>
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('inputPassword', 'パスワード（確認）') !!}
                        {{-- {!! Form::password('password_confirmation', [
                            'class' => 'form-control',
                            'id' => 'inputPassword',
                            'placeholder' => 'パスワード（確認）',
                        ]) !!} --}}
                        <input type="password" id="inputPassword" name="password_confirmation" class="form-control"
                            placeholder="パスワード（確認）" value='{{ old('password') }}'>
                        @error('password_confirmation')
                            <div>
                                <span class="text-danger">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        {!! Form::label('icon_image_path', 'アイコン（任意）') !!}
                        {!! Form::file('nickname', old('icon_image_path'), [
                            'class' => 'form-control',
                            'id' => 'icon_image_path',
                            'placeholder' => 'アイコン（任意）',
                        ]) !!}
                    </div> --}}
                    {!! Form::submit('次へ進む', ['class' => 'btn btn-primary mt-3']) !!}
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
