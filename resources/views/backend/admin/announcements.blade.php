@extends('layout.admin')
@section('main-content')

        <div class="main_content">
            <div class="container news_container">
    <h1>最新公告</h1>
        @if (count($announcement) == 0)
            <div class="card">
                <div class="card-content" style="padding: 1rem; font-size: 1.4rem;">
                    <p style="font-size: 20px">目前還沒有任何公告。</p>
                </div>
            </div>
        @else
            @foreach($announcement as $value)
            <div class="panel">
                <div class="panel-box">
                    <h4><a href="/user/announcement/{{$value['id']}}">{{$value['title']}}&nbsp;&nbsp;<small>{{Carbon\Carbon::parse($value['created_at'])->format('Y.m.d')}}</small></a><h4>
                    {!! strstr($value['content'], '</p>', true).'</p>'!!}    
                    <p><a href="/user/announcement/{{$value['id']}}">[閱讀全文]</a></p>
                </div>
            </div>
            @endforeach
        @endif
@endsection