@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    @if($followers->count() == 0)
        <p>Nothing</p>
    @endif
    @foreach($followers as $follower)
        <div class="row row-list">
            <div class="col-sm-1">
                <div class="avatar-post">
                    @if(!is_null($follower->user->picture))
                    <div class="avatar" style="background: url('{{ url('storage/images/avatar/' . $follower->user->picture) }}')"></div>
                    @else
                    <div class="avatar" style="background: #CCCCCC"></div>
                    @endif
                </div>
            </div>
            <div class="col-sm-11">
                <a href="{{ url('user/' . (is_null($follower->user->username) ? $follower->user->id : $follower->user->username)) }}">
                    <b>{{ $follower->user->name }}</b>
                    @if(!is_null($follower->user->username))
                    <p>@{{ $follower->user->username }}</p>
                    @endif
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection