
<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <title>恆裔金融集團 - 代理專區</title>

    <link rel="stylesheet" href="/css/kule-lazy-full.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/doberman_uc.css">

        <link rel="stylesheet" href="/css/intlTelInput.css">
    @yield('style')
    <style>
        .intl-tel-input .flag-container:hover .selected-flag {
            background: transparent;
        }

        .intl-tel-input .flag-container:hover {
            cursor: default;
            background: transparent;
        }

        .intl-tel-input .arrow {
            display: none;
        }

        .intl-tel-input .ctrl-input {
            border: 0;
            background: transparent;
            color: #000;
            text-shadow: none;
        }

        .intl-tel-input [readonly].ctrl-input {
            cursor: default;
            box-shadow: none;
        }

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
                    <li class="account_feature"><p><i class="fa fa-fw fa-user"></i>&nbsp;{{Session::get('member.name')}} &nbsp;{{Session::get('member.name_en')}} ({{Session::get('member.username')}})</p></li>
                    <li class="account_feature"><a href="/logout" class="lang"><i class="fa fa-sign-out"></i>&nbsp;登出</a></li>
                </ul>
            </div>

            <div class="admin_header_container">
                <h1><span>華都保本保息</span></h1>

                <nav class="first_row">
<!--                     <li ><a href="/agent/dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp;概覽</a></li>
 -->                    <li class="{{($menu == 'announcements') ? 'active' : ''}}"><a href="/admin/announcements"><i class="fa fa-fw fa-feed"></i>&nbsp;公告</a></li>
                    <li class="{{($menu == 'clients') ? 'active' : ''}}"><a href="/admin/clients"><i class="fa fa-fw fa-child"></i>&nbsp;客戶</a></li>
                    <li class="last {{($menu == 'contracts') ? 'active' : ''}}"><a href="/admin/contracts"><i class="fa fa-fw fa-file-o"></i>&nbsp;合約</a></li>
<!--                     <li class=""><a href="/admin/group"><i class="fa fa-fw fa-sitemap"></i>&nbsp;組織</a></li>
                    <li class=" last"><a href="/agent/profile"><i class="fa fa-fw fa-user"></i>&nbsp;個人資料</a></li> -->
                </nav>

                <nav class="second_row">
<!--                     <li class=""><a href="/agent/wallet"><i class="fa fa-fw fa-dollar"></i>&nbsp;佣金帳戶</a></li>
                    <li class=""><a href="/agent/issues"><i class="fa fa-fw fa-history"></i>&nbsp;行政進度查詢</a></li> -->
                    <li class="{{($menu == 'create-client') ? 'active' : ''}}"><a href="/admin/create/client"><strong class="text-focus"><i class="fa fa-user-plus"></i>&nbsp;新客戶</strong></a></li>
                    <li class="{{($menu == 'create-contract') ? 'active' : ''}}"><a href="/admin/create/contract"><strong class="text-warning"><i class="fa fa-plus-circle"></i>&nbsp;新合約</strong></a></li>
                    <li class="{{($menu == 'create-announcement') ? 'active' : ''}} last"><a href="/admin/create/announcements"><strong class="text-secondary"><i class="fa fa-plus-circle"></i>&nbsp;新公告</strong></a></li>
                </nav>
            </div>
        </header>
        @yield('main-content')
        </div>

        <footer>
            <p class="copyright">Copyright &copy; 2018 HengYi Group | All Rights Reserved</p>
        </footer>
    </div>

    <script src="/js/jquery-2.1.4.min.js"></script>
        <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/libphonenumber.js"></script>
    <script src="/js/intlTelInput.min.js"></script>
@section('script')
    <script>
        $("input.mobile").intlTelInput({
            defaultCountry: "hk",
            allowDropdown: false,
            numberType: "MOBILE",
            preferredCountries: ["cn","tw","hk"]
        });
    </script>
@show

</body>
</html>
