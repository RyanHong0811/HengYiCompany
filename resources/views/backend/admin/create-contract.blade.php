@extends('layout.admin')
@section('main-content')
<div class="main_content">
    <div class="container">
        <div class="columns-7">
            <div class="col-7">
                <h1>新增投資人合約</h1>

                <form class="form-horizontal" method="POST" action="/admin/create/contract"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="columns-12 bank_info_box">
                        <div class="col-8">
                            <strong>合約人</strong>
                            <div class="ctrl-grp columns-12">
                                <div class="ctrls col-8">
                                <select name="user_id" class="ctrl-input"> <!--v-for-start-->
                                    @foreach($users as $user)
                                    <option value="{{$user['id']}}">{{$user['username']}} - {{$user['name']}} ({{$user['name_en']}})</option>
                                    <!--v-for-end--> 
                                    @endforeach
                                </select>                                
                                </div>
                            </div>
                            <strong>本次合約金額</strong>
                            <div class="ctrl-grp columns-12">
                                <div class="ctrls col-8">
<!--                                     <select class="ctrl-input"> 
                                        <option value="USD">USD</option> 
                                        <option value="HKD">HKD</option> 
                                    </select>  
                                    <br> -->
                                    <input type="number" name="amount" step="1000" min="0" class="ctrl-input" required>
                                </div>
                            </div>

                            <strong>客戶每年利息率</strong>
                            <div class="ctrl-grp columns-12">
                                <div class="ctrls col-8">
                                    <div class="input-grp"> <input type="number" name="rate" step="0.01" min="0" class="ctrl-input" required> <span class="adorn">%</span> </div> <!--v-if--> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ctrl-group columns-12">
                        <div class="ctrls col-10 col-offset-2">
                            <button type="submit" class="btn size-lg color-primary">
                                <i class="fa fa-fw fa-pencil"></i>&nbsp;
                                新增投資人合約
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection

@section('script')
@parent
    <script src="/js/jquery-2.1.4.min.js"></script>

    <script src="/js/vue.pretty-bytes.js"></script>
    <script src="/js/agent_new_contract.js"></script>
    <script>
    var agent_commission_rate = parseFloat('0');
    </script>
@endsection
