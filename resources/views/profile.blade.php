@extends('layouts.app')

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        var box_height = $('.img-box').outerWidth();
        $('.img-box').css({
            height: box_height + 'px'
        });
        var profile_height = $('.avatar-profile').outerWidth();
        $('.avatar-profile').css({
            height: profile_height + 'px'
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-box clearfix">
                <div class="col-md-2">
                    <div class="avatar-profile">
                        @if($profile->picture != NULL)
                        <div class="avatar" style="background-image: url('{{ url('storage/images/avatars/' . $profile->picture . '.jpg') }}')"></div>
                        @else
                        <div class="avatar" style="background: #CCCCCC"></div>
                        @endif
                    </div>
                </div>
                <div class="col-md-10 profile-detail">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="profile-header-section">
                                <h1>{{ $profile->name }}</h1>
                                <span class="username">&#64;{{ $profile->username }}</span>
                            </div>
                            <div class="profile-header-section">
                                @if(Auth::check() && $profile->id != Auth::id())
                                    @if($followed)
                                    <form action="{{ url('/follow/unfollow') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ $profile->id }}">
                                        <input type="submit" value="Unfollow" class="btn btn-default">
                                    </form>                
                                    @else
                                    <form action="{{ url('/follow/create') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id" value="{{ $profile->id }}">
                                        <input type="submit" value="Follow" class="btn btn-success">
                                    </form>
                                    @endif
                                @endif
                                @if(Auth::check())
                                    @if(Auth::id() == $profile->id)
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="profile-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            More
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="profile-action">
                                            <li><a href="{{ route('edit_profile') }}">Edit profile</a></li>
                                            <li><a href="{{ route('change_password') }}">Change password</a></li>
                                        </ul>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 profile-counter">
                        <div class="row">
                            <div class="profile-counter-section">
                                {{ $profile->post->count() }} Posts
                            </div>
                            <div class="profile-counter-section">
                                {{ $profile->follower->count() }} Followers
                            </div>
                            <div class="profile-counter-section">
                                {{ $profile->followTo->count() }} Following
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if($posts->count() <= 0)
                <h1>No posts yet</h1>
            @else
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="photo-card">
                                <a href="{{ url('/posts/' . $post->id) }}">
                                    <div class="img-box">
                                        <img src="{{ url('storage/images/' . $folder .'/' . $post->photo . '.jpg') }}"><br>
                                    </div>
                                </a>
                                @include('components.button')
                                <div class="description clearfix">
                                    <div class="col-xs-1 col-md-2">
                                        <div class="avatar-post">
                                            @if($post->user->picture != NULL)
                                            <div class="avatar" style="background-image: url('{{ url('storage/images/avatars/' . $post->user->picture . '.jpg') }}')"></div>
                                            @else
                                            <div class="avatar" style="background: #CCCCCC"></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-11 col-md-10">
                                        <div class="description-container">
                                            <b>{{ $post->user->name }}</b><br>
                                            <p>{{ $post->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
