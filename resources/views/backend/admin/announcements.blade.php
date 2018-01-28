@extends('layout.admin')
@section('main-content')

        <div class="main_content">
            <div class="container news_container">
    <h1>最新公告</h1>

        @foreach($announcement as $value)
        <div class="panel">
            <div class="panel-box">
                <h4><a href="/admin/announcement/{{$value['id']}}">{{$value['title']}}&nbsp;&nbsp;<small>{{Carbon\Carbon::parse($value['created_at'])->format('Y.m.d')}}</small></a><h4>
                {!! strstr($value['content'], '</p>', true).'</p>'!!}    
                <p><a href="/admin/announcement/{{$value['id']}}">[閱讀全文]</a></p>
            </div>
        </div>
        @endforeach
@endsection