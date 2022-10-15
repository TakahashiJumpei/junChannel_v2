@section('footer')
    <footer class="footer bg-white mt-5">
        {{-- <div class="container"> --}}
        <div class="text-muted pt-3 pb-3">
            <div class="text-center" style="text-indent:-3em;">
                <a href="{{ url('tos') }}" role="button" class="btn btn-link text-muted text-decoration-none">利用規約</a>
            </div>
            <div class="text-center">
                <a href="{{ url('privacy_policy') }}" role="button"
                    class="btn btn-link text-muted text-decoration-none">プライバシーポリシー</a>
            </div>
            <div class="text-center" style="text-indent:-2em;">
                <a href="{{ url('https://docs.google.com/forms/d/e/1FAIpQLSc-XPGvWdCzaNzelP5cyb_pwIAnGkMPo-ECCSBvR0TIc8qLfA/viewform?usp=sf_link') }}"
                    target="blank" role="button" class="btn btn-link text-muted text-decoration-none">お問い合わせ</a>
            </div>
            <small class="d-block text-center" style="padding-left:12px; text-indent:-2em;"">Copyright © 2020-2022
                nakazaway & jump All Rights Reserved.</small>
        </div>
        {{-- </div> --}}
    </footer>

    <style>
        footer a:hover {
            text-decoration: underline !important;
        }
    </style>
@endsection
