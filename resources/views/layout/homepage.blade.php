<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from www.waldorf-group.com/companies.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jan 2018 03:03:26 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <title>恆裔金融集團 HENGYI GROUP</title>

    <link rel="stylesheet" href="/css/kule-lazy.min.css">
    <link rel="stylesheet" href="/css/kule-theme-default.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/waldorf.css">
</head>
<body >
    <div class="container">
        <div class="header-bar">
            <div class="bar"></div>
            <div class="link"><a href="investor">投資人登入&nbsp;<i class="fa fa-fw fa-user"></i>&nbsp;</a></div>
        </div>

        <div class="header-container">
            <header>
                <a href="/"><h1><span>恆裔金融集團 HENGYI GROUP</span></h1></a>

                <nav>
                    <li class="{{($menu == 'about') ? 'active' : ''}}">
                        <a href="about">
                            <span class="english">About Us</span>
                            <span class="chinese">關於恆裔</span>
                        </a>

                        <div class="columns-12 dropmenu about_us_dropmenu">
                            <div class="col-6">
                                 <ul>
                                    <li><a href="about#history">公司沿革</a></li>
                                    <li><a href="about#future">公司展望</a></li>
                                    <li><a href="about#team">公司團隊</a></li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <img src="/img/main_navi_about_us.jpg" alt="">
                            </div>
                        </div>
                    </li>

                    <li class="{{($menu == 'companies') ? 'active' : ''}}">
                        <a href="companies">
                            <span class="english">Group Companies</span>
                            <span class="chinese">集團介紹</span>
                        </a>

                        <div class="columns-12 dropmenu group_companies_dropmenu">
                            <div class="col-4">
                                <ul>
                                    <li><a href="companies#financial">金融業務</a></li>
                                    <li><a href="companies#estate">地產業務</a></li>
                                    <li><a href="companies#gamble">博彩業務</a></li>
                                </ul>
                            </div>

                            <div class="col-4">
                                <ul>
                                    <li><a href="companies#entertainment">影視娛樂</a></li>
                                    <li><a href="companies#fisheries">漁農業務</a></li>
                                </ul>
                            </div>
                            <div class="col-4">
                                <img src="/img/main_navi_group_companies.jpg" alt="">
                            </div>
                        </div>
                    </li>

                    <li class="{{($menu == 'investor') ? 'active' : ''}}">
                        <a href="investor">
                            <span class="english">Investor Center</span>
                            <span class="chinese">投資人專區</span>
                        </a>
                    </li>

<!--                     <li>
                        <a href="contact">
                            <span class="english">Contact Us</span>
                            <span class="chinese">聯絡我們</span>
                        </a>
                    </li> -->
                </nav>
            </header>
        </div>
        
            @yield('content-view')

    </div>
</body>

<!-- Mirrored from www.waldorf-group.com/companies.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jan 2018 03:03:31 GMT -->
</html>
