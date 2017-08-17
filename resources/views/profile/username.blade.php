@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enter your username</h1>
    <form action="{{ route('set_username') }}" method="POST">
        {{ csrf_field() }}
        <span>{{ url('user') }}/<input type="text" name="username"></span>
    </form>
</div>
@endsection