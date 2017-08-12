@extends('layouts.app')

@section('content')
<div class="container edit-post">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 img-post-view">
            <img src="{{ url('storage/images/' . $folder .'/' . $post->photo . '.jpg') }}">
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
                        <a href="{{ url('user/' . $post->user->username) }}">
                            <b>{{ $post->user->name }}</b>
                        </a><br>
                        <div class="description-box">
                            <form action="{{ url('posts/' . $post->id . '/edit') }}" method="POST">
                                {{ csrf_field() }}
                                <textarea name="description">
                                    {{ $post->description }}
                                </textarea>
                                <input type="submit" class="btn btn-default" value="edit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection