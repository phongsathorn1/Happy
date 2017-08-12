@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>Change password</h1>
        <div class="card clearfix">
            <form method="POST" action="{{ route('change_password') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Your password">
                </div>
                <hr>
                <div class="form-group">
                    <label for="new-password">New password</label>
                    <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Your new password">
                </div>
                <div class="form-group">
                    <label for="new-password_confirmation">Confirm new password</label>
                    <input type="password" class="form-control" name="new-password_confirmation" id="new-password_confirmation" placeholder="Confirm your new password">
                </div>
                <input type="submit" class="btn btn-primary" value="Change password">
            </form>
        </div>
    </div>
</div>
@endsection
