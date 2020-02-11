@extends('layout.main')

@section('title', 'Login')

@section('style')
<style type="text/css">
  .card {
    margin-top: 200px;
  }
</style>
@endsection

@section('content')
<div class="row h-100 justify-content-center align-items-center">
<form name="login" class="w-50" method="POST" action="">
  @csrf
  <div class="card mx-auto">
    <h3 class="card-header">FPT Soft Login</h3>
    <div class="card-body">
      @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
      @endif

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
      <div class="form-group">
        <input type="text" name="email" class="form-control" placeholder="Enter your e-mail">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Enter your password">
      </div>
    </div>
    <div class="card-footer">
      <input type="hidden" name="credentials" value="superadmin">
      <button type="submit" class="btn btn-primary">Login</button>
    </div>
  </div>
</form>
</div>
@endsection
