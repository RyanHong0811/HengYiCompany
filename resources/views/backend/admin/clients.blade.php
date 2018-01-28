@extends('layout.admin')
@section('main-content')
        <div class="main_content">
            <div class="container news_container">
    <h1>客戶列表</h1>
    @if (count($users) == 0)
        <div class="card">
            <div class="card-content" style="padding: 1rem; font-size: 1.4rem;">
                <p style="font-size: 20px">目前還沒有任何客戶。</p>
            </div>
        </div>
    @else
    <table class="table table-striped table-hover">
        <thead>
            <th width="20%">客戶姓名</th>
            <th width="20%">登入帳號</th>
            <th width="20%">行動電話</th>
            <th width="20%">合約數</th>
            <th width="20%">動作</th>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user['name']}}<br><small>{{$user['name_en']}}</small></td>
                <td>{{$user['username']}}</td>
                <td><input type="text" class="ctrl-input mobile" readonly value="{{$user['phone']}}"></td>
                <td>
                    <p><span class="label color-success">生效中</span>&nbsp;&nbsp;{{$user->active_contract()}} 張</p>
                    <p><span class="label">已結束</span>&nbsp;&nbsp;{{$user->end_contract()}} 張</p>
                </td>
                <td><a href="/admin/client/{{$user['id']}}" class="btn size-xs"><i class="fa fa-user"></i>&nbsp;查看客戶合約及資料</a></td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @endif    
</div>
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
