@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($posts->count() == 0)
                <div class="no-post">
                    <div class="no-post-title">No Posts Yet</div>
                    <div class="no-post-description">Follow someone or upload photo to see more posts.</div>
                </div>
            @else
            @foreach($posts as $post)
                <div class="col-md-8 col-md-offset-2 img-post-view">
                    <a href="{{ url('/posts/' . $post->id) }}">
                        <img src="{{ url('storage/images/' . md5($post->user->id) .'/' . $post->photo . '.jpg') }}"><br>
                    </a>
                    @include('components.button')
                    <div class="description clearfix">
                        <div class="col-xs-3 col-md-1">
                            <div class="avatar-post">
                                @if($post->user->picture != NULL)
                                <div class="avatar" style="background-image: url('{{ url('storage/images/avatars/' . $post->user->picture . '.jpg') }}')"></div>
                                @else
                                <div class="avatar" style="background: #CCCCCC"></div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-9 col-md-11">
                            <div class="description-container">
                                <b>{{ $post->user->name }}</b><br>
                                <p>{{ $post->description }}</p>
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