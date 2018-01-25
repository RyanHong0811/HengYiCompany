@extends('layout.customer')
@section('main-content')
<div class="main_content">
    <div class="container wallet-container">
    <div class="tab">
        
        <div class="tab-content active">
            <div class="columns-12">
                <div class="col-5">
                    <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-dollar fa-fw"></i>&nbsp;帳戶可動用額</h3>
                            </div>
                            <div class="card-box">
                                <h4>USD 0.00&nbsp;&nbsp;</h4>

                                                            </div>
                        </div>
                </div>
                <div class="col-5">
                    <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-dollar fa-fw"></i>&nbsp;帳戶價值</h3>
                            </div>
                            <div class="card-box">
                                <h4>USD 0.00</h4>
                            </div>
                        </div>
                </div>
                <div class="col-2"></div>

            </div>

            <br>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">USD 帳戶交易記錄</h3>
                </div>

                <div class="card-box">
                    <div class="wallet-list-container" style="background: #FFF;">
                        <table class="table table-striped balance-sheet table-tight">

                            <thead>
                                <tr>
                                    <th width="15%">日期</th>
                                    <th width="25%">原因</th>
                                    <th width="20%">存入</th>
                                    <th width="20%">提取</th>
                                    <th width="20%">可用結餘</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>2017 Dec 11</td>
                                    <td>
                                        <strong>WITHDRAWAL</strong><br>
                                            <small>提現到銀行(本+利出金)</small>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <span style="color: #080;">(USD 70.00)</span>
                                    </td>
                                    <td>USD 0.00</td>
                                </tr>
                                <tr>
                                    <td>2017 Nov 15</td>
                                    <td>
                                        <strong>INTEREST</strong><br>
                                        <small><a href="/user/contract/9081242">合約 9081242</a> 收益<br>期間 OCT 15 - NOV 14</small>
                                    </td>
                                    <td>
                                        <span style="color: #F00;">USD 70.00</span>                                        </td>
                                    <td>
                                                                                </td>
                                    <td>USD 70.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
@parent
            <div class="modal withdraw_modal" v-if="modalEnabled">
        <component :is="currentView" transition="fade" transition-mode="out-in"></component>
    </div>

    <div class="modal-overlay" v-if="modalEnabled"></div>

        <script>
        var current_currency = 'USD';
        var current_balance = 0.00;

        var bank_name = '台北富邦銀行';
        var bank_swift_code = 'TPBKTWTP';
        var bank_address = '八德分行';
        var bank_account = '340168890740 ';
        var bank_account_name = '張振CHANG,CHEN';

        if( '0' != '' ) {
            current_balance += parseFloat('0');
        }
    </script>

    <script src="/js/vue-1.0.26.min.js"></script>
    <script src="/js/user_withdrawal.js"></script>
@endsection
