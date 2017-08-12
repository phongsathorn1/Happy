@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2 img-post-view">
                <form action="{{ url('upload/post') }}" method="POST">
                    {{ csrf_field() }}
                    <img src="{{ url('storage/images/' . $folder .'/' . $photo . '.jpg') }}"><br>
                    <div class="photo-status">
                        You are all smile 😁. Great! Just post it.
                    </div>
                    <div class="description-box">
                        <b>description:</b>
                        <input type="hidden" name="photo" value="{{ $photo }}">
                        <textarea name="description"></textarea>
                    </div>
                    <input type="submit" class="btn btn-success" value="Just Post It!">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
