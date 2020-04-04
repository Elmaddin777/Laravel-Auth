@extends('layouts.master')
@section('title', 'Admin | Sign in')
@section('content')
  <body class="hold-transition login-page bg-dark">
  <div class="login-box">
    <div class="login-logo">
      <b>Login</b> to start 
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body" style="">
        <p class="login-box-msg">Sign in to start your session</p>
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        @if(session()->has('register_success'))
          <div class="alert alert-success">
              {{ session()->get('register_success') }}
          </div>
        @endif
        @if(session()->has('login_fail'))
          <div class="alert alert-danger">
              {{ session()->get('login_fail') }}
          </div>
        @endif
        <form action="{{ route('login.post') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember" value="1">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="{{ route('reset.index') }}">I forgot my password</a>
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

