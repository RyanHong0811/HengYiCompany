@extends('layout.customer')
@section('main-content')
<div class="main_content">
    <div class="container news_container">
    <a href="/user/contracts" class="btn-outline size-lg"><i class="fa fa-arrow-left"></i>&nbsp;回合約列表</a>

    <br>
    <br>

    <div class="columns-12">
        <div class="col-4">
            <h2>{{$contract['id']}}</h2>

            <dl>
                <dt>狀態</dt>
                <dd>
                                    </dd>

                <dt>合約生效日</dt>
                <dd>{{$contract['start_day']}}</dd>

                <dt>合約到期日</dt>
                <dd>{{$contract['end_day']}}</dd>

                <dt>合約長度</dt>
                <dd>{{ $contract_year }}年</dd>
            </dl>
        </div>

        <div class="col-4">
            <h2><i class="fa fa-fw fa-file-o"></i>&nbsp;合約內容</h2>

            <dl>
                <dt>合約金額</dt>
                <dd><!-- <small>USD</small>  --><strong>{{number_format($contract['amount'], 2)}}</strong></dd>

                <dt>客戶年收益率</dt>
                <dd><strong>{{number_format($contract['rate'], 2)}}</strong> <small>%</small></dd>

                <dt>年佣金率</dt>
                <dd><strong>2.30</strong> <small>%</small></dd>
            </dl>
        </div>

        <div class="col-4">
            <h2><i class="fa fa-fw fa-bank"></i>&nbsp;配發資訊</h2>

            <dl>
                <dt>每期收益</dt>
                <dd><!-- <small>USD</small> --> <strong>{{number_format($every_month_amount, 2)}}</strong></dd>

                <dt>每月配發時間</dt>
                <dd>
                                            15 日
                                    </dd>

                <dt>下次配發日</dt>
                                <dd>{{$next_month}}</dd>
                            </dl>
        </div>
    </div>

    <hr>
<!--     <div class="columns-12">
        <div class="col-6">
            <h2>客戶利息記錄</h2>

            <table class="table table-striped balance-sheet">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>原因</th>
                        <th>變動</th>
                    </tr>
                </thead>

                <tbody>
                                            <tr>
                            <td>2017 Nov 15</td>
                            <td>
                                <strong>INTEREST</strong><br>

                                                                <small>期間 OCT 15 - NOV 14</small>
                                
                                
                                                            </td>
                            <td><span style="color: #F00;">+USD 70.00</span></td>
                        </tr>
                                    </tbody>
            </table>
        </div>

        <div class="col-6">
            <h2>佣金配發記錄</h2>

            <table class="table table-striped balance-sheet">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>原因</th>
                        <th>變動</th>
                    </tr>
                </thead>

                <tbody>
                                            <tr>
                            <td>2017 Nov 15</td>
                            <td>
                                <strong>COMMISSION</strong><br>

                                
                                
                                                            </td>
                            <td><span style="color: #F00;">+USD 19.17</span></td>
                        </tr>
                                    </tbody>
            </table>
        </div>
    </div> -->
</div>
@endsection