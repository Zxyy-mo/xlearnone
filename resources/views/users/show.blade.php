@extends('layouts.default')
@section('title', $user->name)
@section('content')
  <div class="row">
    <div class="offset-md-2 col-md-8">
      <div class="col-md-12">
        <div class="offset-md-2 col-md-8">
          <section class="user_info">
{{--            @include('shared._user_info', ['user' => $user])--}}
            @include('shared._user_info')
{{--            这里传入参数也可以因为本身include就是将页面引入进来--}}
          </section>
        </div>
      </div>
    </div>
  </div>
@stop
