<!DOCTYPE html>
<!-- saved from url=(0043)https://uc.waldorf-group.com/user/contracts -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>恆裔金融集團 - 投資人專區</title>

    <link rel="stylesheet" href="/css/kule-lazy-full.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/doberman_uc.css">
    @yield('style')
    <style>
    tr.inactive td {
        color: #999;
    }
    </style>
</head>
<body>

    <div class="page_container">
        <header>
            <div class="language_account_feature">
                <ul>
                    <li class="account_feature"><p><i class="fa fa-fw fa-user"></i>&nbsp;張振 (CHANG,CHEN)</p></li>
                    <li class="account_feature"><a href="/logout" class="lang"><i class="fa fa-sign-out"></i>&nbsp;登出</a></li>
                </ul>
            </div>

            <div class="header_container">
                <h1><span>2091 二元期權</span></h1>

                <nav>
                    <li class="{{($menu == 'dashboard') ? 'active' : ''}}" ><a href="/user/dashboard">帳戶概覽</a></li>
                    <li class="{{($menu == 'announcements') ? 'active' : ''}}" ><a href="/user/announcements">最新公告</a></li>
                    <li class="{{($menu == 'contracts') ? 'active' : ''}}" ><a href="/user/contracts">合約列表<!--  <span class="badge">&nbsp;0&nbsp;</span> --></a></li>
                    <li class="{{($menu == 'wallet') ? 'active' : ''}}" ><a href="/user/wallet">帳戶錢包</a></li>
                    <li class="{{($menu == 'profile') ? 'active' : ''}}"><a href="/user/profile">個人檔案</a></li>
<!--                     <li class="{{($menu == 'issues') ? 'active' : ''}} last"><a href="/user/issues">服務進度查詢</a></li> -->
                </nav>

                <div class="clearfix"></div>
            </div>
        </header>
        @yield('main-content')
        </div>

        <footer>
            <p class="copyright">Copyright © 2018 Waldorf Group | All Rights Reserved</p>
        </footer>
    </div>
@section('script')
<script src="/js/jquery-2.1.4.min.js"></script>

<script>

    $(".tab-nav-item a").on("click", function() {
        var target = $(this).attr("href");

        // update the panel
        $(".tab-content").hide();
        $(target).show();

        // update the navbar
        $(".tab-nav-item").removeClass("active");
        $(this).parent().addClass("active");

        return false;
    });
</script>
@show

</body></html>