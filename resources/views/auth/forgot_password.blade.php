@extends('layouts.master')
@section('title', 'Admin | Reset')
@section('content')
  <body class="hold-transition login-page bg-dark">
  <div class="login-box">
    <div class="login-logo">
      <b>Password</b> reset
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
        @if (session()->has('reset_fail'))
          <div class="alert alert-danger">
            {{ session()->get('reset_fail') }}
          </div>
        @endif
        @if (session()->has('email_success'))
          <div class="alert alert-success">
            {{ session()->get('email_success') }}
          </div>
        @endif
        <form action="{{ route('reset.post') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email"placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="{{ route('login.index') }}">Login</a>
        </p>
        <p class="mb-0">
          <a href="{{ route('register.index') }}" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
@endsection


