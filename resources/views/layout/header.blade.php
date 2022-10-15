@section('header')
    <header class="header sticky-top">
        <nav class="navbar navbar-dark navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand font-weight-bold" href="/top">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('categories') }}">
                            カテゴリ一覧
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('thread/post') }}">
                            スレッドの作成
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    {!! Form::open(['url' => '/search', 'method' => 'get', 'files' => true, 'class' => 'form-inline my-2 my-lg-0']) !!}
                    {!! Form::search('str', $str ?? '', [
                        'class' => 'form-control mr-sm-2',
                        'placeholder' => 'スレッドの検索',
                    ]) !!}
                    {!! Form::button('検索', [
                        'class' => 'btn btn-outline-light my-2 my-sm-0',
                        'type' => 'submit',
                    ]) !!}
                    {!! Form::close() !!}

                    @if (Auth::guard('user')->check())
                        <?php $user = Auth::guard('user')->user(); ?>
                        <li class="nav-item ml-2">
                            <a class="nav-link text-light" href="{{ url('my_page', $user->id) }}">
                                @if (!empty($user->nickname))
                                    {{ $user->nickname }}
                                @else
                                    名無し
                                @endif
                                さん
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('signout') }}">ログアウト</a>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                通知
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li> --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('signup') }}">会員登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('signin') }}">ログイン</a>
                        </li>
                    @endif
                </ul>
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
