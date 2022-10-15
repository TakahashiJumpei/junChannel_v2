@section('header')
    <header class="header sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="/top">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('categories') }}">カテゴリ一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('thread/post') }}">スレッドの作成</a>
                        </li>
                    </ul>
                    {!! Form::open([
                        'url' => '/search',
                        'method' => 'get',
                        'files' => true,
                        'class' => 'd-flex form-inline my-2 my-lg-0',
                    ]) !!}
                    {!! Form::search('str', $str ?? '', [
                        'class' => 'form-control me-sm-2',
                        'placeholder' => 'スレッドの検索',
                    ]) !!}
                    {!! Form::button('検索', [
                        'class' => 'btn btn-outline-light my-2 my-sm-0',
                        'type' => 'submit',
                    ]) !!}
                    {!! Form::close() !!}
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        @if (Auth::guard('user')->check())
                            <?php $user = Auth::guard('user')->user(); ?>
                            <li class="nav-item ms-2">
                                <a class="nav-link active" href="{{ url('my_page', $user->id) }}">
                                    @if (!empty($user->nickname))
                                        {{ $user->nickname }}
                                    @else
                                        名無し
                                    @endif
                                    さん
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('signout') }}">ログアウト</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('signup') }}">会員登録</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('signin') }}">ログイン</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <style>
        input {
            width: 300px !important;
        }

        @media screen and (min-width:450px) {
            input {
                width: 350px !important;
            }
        }
    </style>
@endsection
