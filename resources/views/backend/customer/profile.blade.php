@extends('layout.customer')
@section('style')
<style>
hr {
    margin: 1rem 0;
}

h2 {
    margin: 0;
    margin-bottom: 1rem;
}

table td {
    height: 3rem;
    line-height: 3rem;
}

table.buttons td {
    height: 4rem;
}

table td.label_txt {
    color: #666;
    font-size: 0.9rem;
}

table td.data_txt {
    font-size: 0.8rem;
    color: #333;
}
</style>
@endsection
@section('main-content')
        <div class="main_content">
            <div class="container">
<div class="columns-7">
    <div class="col-4">
        <h1>個人檔案</h1>
        <p>你可以在下面查看您的個人資料，並在右邊提出資料修改請求。<br><strong>請注意：</strong>有一些資料修改需要提交相關的檢核資料。</p>

        <div class="panel">
            <div class="panel-box">
                <h2>
                    <i class="fa fa-fw fa-child"></i>
                    張振
                    <small>CHANG,CHEN</small>
                </h2>

                <table>

                    <tbody><tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-phone"></i>&nbsp;
                            <small>登記電話</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            +886956676496
                        </td>
                    </tr>

                    <tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-envelope-o"></i>&nbsp;
                            <small>電子郵箱</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            dj13333@yahoo.com.tw
                        </td>
                    </tr>


                    <tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-building"></i>&nbsp;
                            <small>登記地址</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            
                        </td>
                    </tr>
                </tbody></table>
            </div>
        </div>

        <hr>

        <h2>銀行資訊</h2>

        <div class="panel">
            <div class="panel-box">
                                <h2>
                    <i class="fa fa-fw fa-bank"></i>
                    台北富邦銀行
                    <small>TPBKTWTP</small>
                </h2>

                <table>
                    <tbody><tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-building"></i>&nbsp;
                            <small>銀行地址</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            八德分行
                        </td>
                    </tr>

                    <tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-credit-card"></i>&nbsp;
                            <small>帳戶號碼</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            340168890740 
                        </td>
                    </tr>


                    <tr>
                        <td class="label_txt">
                            <i class="fa fa-fw fa-user"></i>&nbsp;
                            <small>帳戶名稱</small>
                        </td>

                        <td colspan="3" class="data_txt">
                            張振CHANG,CHEN
                        </td>
                    </tr>
                </tbody></table>
                            </div>
        </div>
    </div>
    <div class="col-3">
<!--         <div class="card">
            <div class="card-box">
                <h2>我要修改...</h2>

                <table class="buttons">

                    <tbody><tr>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile/bank" class="btn-outline size-lg">銀行資訊 <i class="fa fa-fw fa-bank"></i></a>
                        </td>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile/password" class="btn-outline size-lg">登入密碼 <i class="fa fa-fw fa-certificate"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile#" class="btn-outline size-lg disabled">姓名證件 <i class="fa fa-fw fa-child"></i></a>
                        </td>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile#" class="btn-outline size-lg disabled">登記地址 <i class="fa fa-fw fa-building"></i></a>
                        </td>
                    </tr>

                    <tr>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile#" class="btn-outline size-lg disabled">登記手機 <i class="fa fa-fw fa-phone"></i></a>
                        </td>
                        <td width="50%">
                            <a href="https://uc.waldorf-group.com/user/profile#" class="btn-outline size-lg disabled">登記電郵 <i class="fa fa-fw fa-envelope-o"></i></a>
                        </td>
                    </tr>
                </tbody></table>
            </div>
        </div> -->

        <br>

        <div class="card color-primary">
            <div class="card-box">
                <h4>聯絡我們</h4>

                <p>若您有任何詢問或是有關行政事務上的任何問題，都歡迎您和您的客戶經理直接連絡，或使用下面提供的方式連絡客服人員。</p>

                                <a href="mailto:bond@waldorfbullion.com" class="btn-outline"><i class="fa fa-fw fa-envelope-o"></i>&nbsp;電郵</a>
            </div>
        </div>
    </div>
</div>
@endsection