@extends('layouts.app')

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        var h = $('.img-box').outerWidth();
        $('.img-box').css({
            height: h + 'px'
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Discover</h1>
            @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="row">
                        <div class="photo-card">
                            <a href="{{ url('/posts/' . $post->id) }}">
                                <div class="img-box">
                                    <img src="{{ url('storage/images/' . md5($post->user->id) .'/' . $post->photo . '.jpg') }}"><br>
                                </div>
                            </a>
                            @include('components.button')
                            <div class="description clearfix">
                                <div class="col-xs-3 col-md-2">
                                    <div class="avatar-post">
                                        @if($post->user->picture != NULL)
                                        <div class="avatar" style="background-image: url('{{ url('storage/images/avatars/' . $post->user->picture . '.jpg') }}')"></div>
                                        @else
                                        <div class="avatar" style="background: #CCCCCC"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-9 col-md-10">
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
        </div>
    </div>
</div>
@endsection