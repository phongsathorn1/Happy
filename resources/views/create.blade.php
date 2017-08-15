@extends('layouts.app')

@section("script")
<link href="{{ asset('css/emotion.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2 img-post-view">
                <img src="{{ url('storage/images/' . $folder .'/' . $photo . '.jpg') }}"><br>
                <div class="photo-status">
                    <div class="photo-detail">
                        <span>{{ $people_count }} peoples in this photo.</span><br>
                    </div>
                    <div class="emotion-badge">
                        @foreach( $photo_emotion as $emotion => $count)
                            <div class="col-sx-1 emotion-badge-list emotion-{{ $emotion }}">
                                <div class="emotion-icon-block">
                                    <i class="emotion-icon"></i>
                                </div>
                                <div class="emotion-count">
                                    {{ $count }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($emotion_pass)
                        OK! I think you are happy 😁. Let post it!.
                    @else
                        Someone in this picture is not happy. 🙁
                    @endif
                </div>
                @if($emotion_pass)
                <div class="description-box">
                    <form action="{{ url('upload/post') }}" method="POST">
                        {{ csrf_field() }}
                        <b>description:</b>
                        <input type="hidden" name="photo" value="{{ $photo }}">
                        <textarea name="description"></textarea>
                        <input type="submit" class="btn btn-success" value="Just Post It!">
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
