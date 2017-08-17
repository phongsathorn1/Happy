@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enter your username</h1>
    <form class="form-inline" action="{{ route('set_username') }}" method="POST">
        {{ csrf_field() }}
        <span>Your username is the same as your Profile address:</span><br>
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <div class="username-field"><b>Your Profile link:</b>{{ url('user') }}/
                <input type="text" name="username" class="form-control" min="3" max="16">
                @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection