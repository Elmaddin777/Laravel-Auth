<!DOCTYPE html>
<html>
  <head>
    <title>Reset Password</title>
  </head>
  <body>
    <h2>We will help you to reset your password</h2>
    <br/>
    Your registered email-id is {{ $email }} , Please click on the below link to reset your password
    <br/>
    <a href="{{ url('reset/password', $link) }}">Reset now!</a>
  </body>
