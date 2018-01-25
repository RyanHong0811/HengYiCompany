@extends('layout.homepage')
@section('content-view')

                <div class="content_navigation category-investor"></div>
        
        <div class="content content-login">
        
<div class="columns-12 content-login" id="content">
    <div class="col-3 section-menu">
        <h2 class="section-title"><img src="/img/content_small_waldorf.png">&nbsp;INVESTOR CENTER</h2>

        <p class="tips">為確保閣下資金的安全，若閣下於公眾場所使用本系統，請務必在使用完畢後登出</p>
        <p class="tips">本頁採用 HTTPS 加密協定進行資料傳輪加密，閣下可放心登入進行操作</p>
    </div>

    <div class="col-9">
        <h2 class="page-title">客戶登入 <small>Investor Login</small></h2>
            <form action="/login" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="referrer" value="1">

                <label for="username"><i class="fa fa-child"></i>&nbsp;帳號</label>
                <input type="text" name="username" class="ctrl-input">

                <label for="password"><i class="fa fa-fw fa-asterisk"></i>&nbsp;密碼</label>
                <input type="password" name="password" class="ctrl-input">

                <button type="submit" class="btn color-waldorf">登入 <small>LOG IN</small></button>
            </form>
    </div>

</div>
        </div>
    </div>
@endsection
