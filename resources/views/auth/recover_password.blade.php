@extends('layouts.master')
@section('title', 'Admin | Recover')
@section('content')
  <body class="hold-transition login-page bg-dark">
    <div class="login-box">
      <div class="login-logo">
        <b>Password</b> recovery
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">

          <form action="{{ route('recover.post') }}" method="post">
            @csrf
            <p class="login-box-msg">You are only one step away from your new password</p>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="New Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <input type="hidden" name="user_token" value="{{ $user_token }}">
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Change password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <p class="mt-3 mb-1">
            <a href="{{ route('login.index') }}">Login</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
@endsection
