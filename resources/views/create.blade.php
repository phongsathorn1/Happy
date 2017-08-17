@extends('layouts.app')

@section("script")
<link href="{{ asset('css/emotion.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2 img-post-view">
                <div class="img-block">
                    @foreach($face_rectangles as $face_ractangle)
                    <div class="faceborder {{ $face_ractangle['emotion'] }}" style="top: {{ $face_ractangle['top'] }}%; left: {{ $face_ractangle['left'] }}%; height: {{ $face_ractangle['height'] }}%; width: {{ $face_ractangle['width'] }}%"></div>
                    @endforeach
                    <img src="{{ url('storage/images/' . $folder .'/' . $photo . '.jpg') }}"><br>
                </div>
                <div class="photo-status">
                    <div class="photo-detail">
                        <span>{{ $people_count }} peoples in this photo.</span><br>
                    </div>
                    <div class="emotion-badge clearfix">
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
                    @elseif($people_count == 0)
                        We can't detect face in this picture 😅. <a href="{{ route('upload') }}" class="btn btn-info">Try Again</a>
                    @else
                        Someone in this picture is not happy 🙁. <a href="{{ route('upload') }}" class="btn btn-info">Try Again</a>
                    @endif
                </div>
                @if($emotion_pass)
                <div class="description-box">
                    <form action="{{ url('upload/post') }}" method="POST">
                        {{ csrf_field() }}
                        <b>description:</b>
                        <input type="hidden" name="photo" value="{{ $photo }}">
                        <input type="hidden" name="people_count" value="{{ $people_count }}">
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
