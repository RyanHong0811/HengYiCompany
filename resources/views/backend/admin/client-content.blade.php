@extends('layout.admin')
@section('script')
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
@endsection
@section('main-content')
        <div class="main_content">
            <div class="container news_container">
    <a href="/admin/clients" class="btn-outline size-lg"><i class="fa fa-arrow-left"></i>&nbsp;回到列表</a>

    <br>
    <br>

    <div class="columns-12">
        <div class="col-4">
            <h2>{{$user['name']}}<br><small>{{$user['name_en']}}</small></h2>

            <dl>
                <dt>登入帳號</dt>
                <dd>{{$user['username']}}</dd>

                <dt>合約數</dt>
                <dd><span class="label color-success">生效中</span>&nbsp;{{$user->active_contract()}} 張</dd>
                <dd><span class="label">已結束</span>&nbsp;{{$user->end_contract()}} 張</dd>
            </dl>
        </div>

        <div class="col-4">
            <h2><i class="fa fa-fw fa-phone"></i>&nbsp;連絡資訊</h2>


            <dl>
                <dt>行動電話</dt>
                <dd><input type="text" class="ctrl-input mobile" readonly value="{{$user['phone']}}"></dd>

                <dt>地址</dt>
                <dd>{{ (!empty($user['address'])) ? $user['address'] : '目前沒有提供地址資訊' }}</dd>

                <dt>E-mail</dt>
                <dd>{{$user['email']}}</dd>
            </dl>
        </div>

        <div class="col-4">
            <h2><i class="fa fa-fw fa-bank"></i>&nbsp;銀行資料</h2>

            <dl>
                <dt>銀行名稱</dt>
                <dd>{{$user['bank_name']}}<br><small><!-- <strong>SWIFT:</strong> MKTBTWTP</small> --></dd>

                
                <dt>銀行帳戶</dt>
                <dd>{{$user['bank_account']}}<br>{{$user['bank_user_name']}}</dd>

            </dl>
        </div>
    </div>

    <hr>

    <h2>客戶合約一覽</h2>

    <table class="table table-striped table-hover">
        <thead>
            <th width="13%">合約編號</th>
            <th width="15%">金額</th>
            <th width="14%">客戶年利率<br>年佣金率</th>
            <th width="13%">起</th>
            <th width="13%">迄</th>
            <th width="15%">動作</th>
        </thead>

        <tbody>
            @foreach($contracts as $key => $contract)
            <tr>
                <td>{{$key + 1}}</th>
                <td>{{$contract['amount']}}</th>
                <td>{{$contract['rate']}}</th>
                <td>{{$contract['start_day']}}</th>
                <td>{{$contract['end_day']}}</th>
                <td></th>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('script')
@parent
    <script>
        $("input.mobile").intlTelInput({
            defaultCountry: "hk",
            allowDropdown: false,
            numberType: "MOBILE",
            preferredCountries: ["cn","tw","hk"]
        });
    </script>
@endsection
