@extends('layouts.auth')

@section('content')
<div class="clearfix">
    <div class="col-md-6 login-description">
        <h1>Welcome To Happy</h1>
        <p>Sign in with your account to enjoy with Happy.</p>
    </div>
    <div class="col-md-6 login-panel">
        <a href="{{ url('login/facebook') }}" class="btn btn-facebook-login"><i class="fa fa-facebook" aria-hidden="true"></i> Login with Facebook</a>
        <a href="{{ url('login/google') }}" class="btn btn-google-login"><i class="fa fa-google" aria-hidden="true"></i> Login with Google</a>
        <a href="{{ url('login/twitter') }}" class="btn btn-twitter-login"><i class="fa fa-twitter" aria-hidden="true"></i> Login with Twitter</a>
    </div>
</div>
@endsection