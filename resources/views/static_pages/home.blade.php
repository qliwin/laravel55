{{--继承父视图--}}
@extends('layouts.default')
@section('title', '主页')
@section('content')
@if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')
        </section>
        <h3>微博列表</h3>
        @include('shared._feed')
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user' => Auth::user()])
        </section>
        
        {{-- 社交的统计信息，如关注人数、粉丝数、微博发布数 --}}
        <section class="stats">
          @include('shared._stats', ['user' => Auth::user()])
        </section>

      </aside>
    </div>
@else
{{--替换父视图的content位置，@section开始到@stop结束--}}

  <div class="jumbotron">
    <h1>Hello Laravel</h1>
    <p class="lead">
      你现在所看到的是 <a href="https://laravel-china.org/courses/laravel-essential-training-5.1">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p>
  </div>
@endif
@stop
