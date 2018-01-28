@extends('layout.customer')
@section('main-content')

        <div class="main_content">
            <div class="container news_article_container">
    <div class="columns-7">
        <div class="col-1" style="padding-top: 30px;">
            <a href="/user/announcements" class="btn-outline"><i class="fa fa-fw fa-arrow-left"></i>&nbsp;回到列表</a>
        </div>

        <div class="col-6">
            <div class="panel">
                <div class="panel-box">
                    <h2>{{$announcement['title']}}&nbsp;&nbsp;<small>{{Carbon\Carbon::parse($announcement['created_at'])->format('Y.m.d')}}</small></h2>
                    {!!$announcement['content']!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection