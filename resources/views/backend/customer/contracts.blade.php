@extends('layout.customer')
@section('main-content')
<div class="main_content">
    <div class="container contract-containter">
    <h1>合約列表</h1>

    <div class="tab">
        <ul class="tab-nav">
            <li class="tab-nav-item active">
                <a href="#active-tab" class="tab-link">生效中</a>
            </li>
            <li class="tab-nav-item">
                <a href="#inactive-tab" class="tab-link">已結束</a>
            </li>
        </ul>

        <div id="active-tab" class="tab-content active">
                            <div class="card">
                    <div class="card-content" style="padding: 1rem; font-size: 1.4rem;">
                        <p>您目前還沒有任何生效中的合約，有新合約時就會轉進這個列表。</p>
                    </div>
                </div>
                    </div>

        <div id="inactive-tab" class="tab-content">
                        <table class="table table-striped table-hover  ">
                <thead>
                    <tr>
                        <th>合約編號</th>
                        <th>合約日期</th>
                        <th>截止日期</th>
                        <th>合約金額</th>
                        <th>預期收益</th>
                        <th>已配發收益</th>
                        <th>動作</th>
                    </tr>
                </thead>

                <tbody>
                                            <tr class="inactive">
                            <td>9081242<br><span class="label">已結束</span></td>
                            <td>2017-10-15</td>
                            <td>2018-10-15</td>
                            <td>USD 10,000.00</td>
                            <td>USD 840.00</td>
                            <td>USD 70.00</td>
                            <td>
                                <a href="https://uc.waldorf-group.com/user/contract/9081242" class="btn">
                                    <i class="fa fa-search fa-fw"></i>&nbsp;
                                    查看記錄
                                </a>
                            </td>
                        </tr>
                                    </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3">小計</td>
                        <td>USD 10,000.00</td>
                        <td>USD 840.00</td>
                        <td>USD 70.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
                    </div>
    </div>
</div>
@endsection

@section('script')
@parent
<script>
    $(".tab-nav-item a").on("click", function() {
        var target = $(this).attr("href");

        // update the panel
        $(".tab-content").hide();
        $(target).show();

        // update the navbar
        $(".tab-nav-item").removeClass("active");
        $(this).parent().addClass("active");

        return false;
    });
</script>
@endsection