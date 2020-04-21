@extends('layouts.default')
@section('title','更新用户资料')
@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card">
    <div class="card-header">
      <h5>更新用户资料</h5>
    </div>
    <div class="card-body">
      @include('shared._error')
      <div class="gravatar_eidt">
        <a href="https://gravatar.com/emails" target="_blank">
          <img src="{{$user->gravatar('200')}}" alt="{{$user->name}}" class="gravatar">
        </a>
      </div>
      <form method="POST" action="{{route('users.update',$user->id)}}">
          {{method_field('PUT')}}
          @csrf
        <div class="form-group">
          <label for="name">名称:</label>
          <input type="text" name="name" id="name" class="form-control"  value="{{$user->name}}">
        </div>
        <div class="form-group">
          <label for="email">邮箱:</label>
          <input type="text" name="email" id="email" class="form-control" disabled value="{{$user->email}}">
        </div>
        <div class="form-group">
          <label for="password">密码:</label>
          <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}">
        </div>
        <div class="form-group">
          <label for="password_confirmation">确认密码:</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{old('password_confirmation')}}">
        </div>
        <button type="submit" class="btn btn-primary">更更新</button>
      </form>
    </div>
  </div>
</div>
@endsection
