@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h1>Change password</h1>
        <div class="card clearfix">
            <form method="POST" action="{{ route('change_password') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Your password">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <hr>
                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <label for="new-password">New password</label>
                    <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Your new password">
                    @if ($errors->has('new-password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new-password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('new-password_confirmation') ? ' has-error' : '' }}">
                    <label for="new-password_confirmation">Confirm new password</label>
                    <input type="password" class="form-control" name="new-password_confirmation" id="new-password_confirmation" placeholder="Confirm your new password">
                    @if ($errors->has('new-password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new-password_comfirmation') }}</strong>
                    </span>
                    @endif
                </div>
                <input type="submit" class="btn btn-primary" value="Change password">
            </form>
        </div>
    </div>
</div>
@endsection
