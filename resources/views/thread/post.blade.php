@extends('layout.app')

@section('title', 'スレッドの作成 - ' . config("app.name"))
@include('layout.header')
@include('layout.footer')

@section('content')
    <div class="col-md-12">
        <div class="mt-5 mb-5">
            {!! Form::open(['url' => '/thread/create', 'method' => 'post', 'files' => true]) !!}
            {!! Form::hidden('createrId', Auth::guard('user')->user()->id) !!}
            @if ($errors->any())
                <div class="mb-3">
                    <span class="text-danger">スレッドの作成に失敗しました。</span>
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('inputTitle', 'タイトル（30文字以内）') !!}
                {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'inputTitle', 'placeholder' => 'タイトル']) !!}
                @error('name')
                    <div>
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="form-group mt-4">
                {!! Form::label('selectCategory', 'カテゴリ') !!}
                {!! Form::select('categoryId', $categories, $categoryId, [
                    'class' => 'form-control',
                    'id' => 'selectCategory',
                    'placeholder' => '選択してください',
                ]) !!}
                @error('categoryId')
                    <div>
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="form-group mt-4">
                {!! Form::label('inputExplanation', 'スレッドの説明（1000文字以内）') !!}
                {!! Form::textarea('explanation', null, [
                    'class' => 'form-control',
                    'id' => 'inputExplanation',
                    'placeholder' => 'スレッドの説明を記載',
                    'rows' => '6',
                ]) !!}
                @error('explanation')
                    <div>
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-center mt-5">
                {!! Form::submit('スレッド作成', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <style>
        label {
            margin-bottom: 0px !important;
        }

        .form-group input {
            width: 100% !important;
        }
    </style>
@endsection
