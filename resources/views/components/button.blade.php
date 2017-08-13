<div class="post-buttons-box clearfix">
@if (Auth::check())
    @if ($post->likes->where('user_id', Auth::id())->count() <= 0)
    <div class="post-buttons-item">
        <form action="{{ url('posts/' . $post->id . '/like') }}" method="POST" class="post-form form-inline">
            {{ csrf_field() }}
            <button type="submit" class="like-button flat-button"><i class="fa fa-heart-o" aria-hidden="true"></i> <span class="like-count">{{ $post->likes->count() }}</span></button> 
        </form>
    </div>
    @else
    <div class="post-buttons-item">
        <form action="{{ url('posts/' . $post->id . '/unlike') }}" method="POST" class="post-form form-inline">
            {{ csrf_field() }}
            <button type="submit" class="like-button flat-button"><i class="fa fa-heart" aria-hidden="true"></i> <span class="like-count">{{ $post->likes->count() }}</span></button>
        </form>
    </div>
    @endif
@endif
    <div class="post-buttons-item">
        <i class="fa fa-comments" aria-hidden="true"></i> {{ $post->comments->count() }}
    </div>
@if(Auth::check())
    @if(Auth::id() == $post->user_id)
        <div class="pull-right">
            @include('components.postaction')
        </div>
    @endif
@endif
</div>