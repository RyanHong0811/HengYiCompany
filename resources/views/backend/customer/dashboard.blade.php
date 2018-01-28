@extends('layout.customer')
@section('main-content')

<div class="main_content">
    <div class="container dashboard_container">
    <div class="columns-7">
        <div class="col-5 news_container">
            <h2>最新公告</h2>
            @if (count($announcement) == 0)
                <div class="card">
                    <div class="card-content" style="padding: 1rem; font-size: 1.4rem;">
                        <p style="font-size: 20px">目前還沒有任何公告。</p>
                    </div>
                </div>
            @else
                @foreach($announcement as $value)
                <div class="panel">
                    <div class="panel-box">
                        <h4><a href="/user/announcement/{{$value['id']}}">{{$value['title']}}&nbsp;&nbsp;<small>{{Carbon\Carbon::parse($value['created_at'])->format('Y.m.d')}}</small></a><h4>
                        {!! strstr($value['content'], '</p>', true).'</p>'!!}    
                        <p><a href="/user/announcement/{{$value['id']}}">[閱讀全文]</a></p>
                    </div>
                </div>
                @endforeach
            @endif
            <div align="right" style="padding-top: 20px;">
                <a href="/user/announcements" class="btn-outline">更多公告 <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-2 info_container">
<!--             <div class="card color-common">
                <div class="card-box">
                    <h4>張振，您好</h4>
                    <h5>當前帳戶可動用餘額</h5>
                                        <p class="figure">USD 0.00</p>
                                    </div>
            </div>
            <br> -->
            <div class="card color-primary">
                <div class="card-box">
                    <h4>聯絡我們</h4>

                    <p>若您有任何詢問或是有關行政事務上的任何問題，都歡迎您和您的客戶經理直接連絡，或使用下面提供的方式連絡客服人員。</p>

                                        <a href="mailto:hong.ying.zu@gmail.com" class="btn-outline"><i class="fa fa-fw fa-envelope-o"></i>&nbsp;電郵</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
    <script src="/public/js/jquery-2.1.4.min.js"></script>
        <script>
    $("a.close").on("click", function() {
        $(".modal").remove();
        $(".modal-overlay").remove();
    });
    </script>
@endsection
