@extends('layout.admin')
@section('main-content')
<div class="main_content">
    <div class="container">
        <div class="columns-7">
            <div class="col-7">
                <h1>新增公告</h1>

                <form class="form-horizontal" method="POST" action="/admin/create/announcements"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="columns-12 bank_info_box">
                        <div class="col-12">
                            <strong>公告標題</strong>
                            <div class="ctrl-grp columns-12">
                                <div class="ctrls col-8">
<!--                                     <select class="ctrl-input"> 
                                        <option value="USD">USD</option> 
                                        <option value="HKD">HKD</option> 
                                    </select>  
                                    <br> -->
                                    <input type="text" name="title"  class="ctrl-input" required>
                                </div>
                            </div>

                            <strong>內文</strong>
                            <div class="ctrl-grp columns-12">
                                <div class="ctrls col-8">
                                    <div class="input-grp"> <textarea id="textarea"  name="content" class="ctrl-input" rows="20" cols="80"></textarea> </div> <!--v-if--> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ctrl-group columns-12">
                        <div class="ctrls col-10 col-offset-2">
                            <button type="submit" class="btn size-lg color-primary">
                                <i class="fa fa-fw fa-pencil"></i>&nbsp;
                                新增公告
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
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script>
    var agent_commission_rate = parseFloat('0');
    CKEDITOR.replace('textarea')
    </script>
@endsection
