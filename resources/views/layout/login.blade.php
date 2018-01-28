
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>恆裔集團</title>

    <link rel="stylesheet" href="/css/kule-lazy-full.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/doberman_uc.css">

    </head>
<body style="height: auto;">

    <div class="login_container">
        <div class="login_form_container" style="padding: 1rem;">
            <h1>&nbsp;&nbsp;&nbsp;恆裔集團</h1>
            <br>
            @if (empty($error))
                <p class="bg-secondary" style="padding: 10px; letter-spacing: 1px;"><strong>提示：</strong>本頁一樣是恆裔系統登入頁面，因系統偵測你的環境需要更多的安全設置，所以轉頁到這裡登入</p>
            @else
                <p class="bg-focus" style="padding: 10px; letter-spacing: 1px;"><strong>系統訊息：</strong>資料不足，請確認輸入的登入帳號及登入密碼</p>
            @endif

            <form action="/login" method="POST" style="text-align: center;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" name="username" placeholder="登入帳號" autocomplete="off" class="ctrl-input">
                <input type="password" name="password" placeholder="登入密碼" autocomplete="off" class="ctrl-input">

                <br>

<!--                 <a href="/forget_password" class="btn"><i class="fa fa-fw fa-unlock"></i>&nbsp;忘記密碼</a>&nbsp;&nbsp;
 -->                
                <button type="submit" class="btn color-primary">登入用戶系統&nbsp;<i class="fa fa-arrow-circle-right"></i></button>
            </form>
        </div>

        <footer>
            <p class="copyright">Copyright &copy; 2018 HengYi Group | All Rights Reserved</p>
        </footer>
    </div>

    <script src="/public/js/jquery-2.1.4.min.js"></script>
</body>
</html>
