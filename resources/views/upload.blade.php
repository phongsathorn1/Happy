@extends('layouts.app')

@section('script')
    <script type="text/javascript" src="{{ url('js/camera.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var h = $('.camera').outerHeight();
            $('.camera-output').css({
                height: h + 'px'
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
    <h1>Upload Photo</h1>
</div>
<div class="container-fluid camera-background">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3">
                <h2>Camera</h2>
                <div class="camera">
                    <div id="camera-error" style="display:none;">
                        <p>
                            Can't get content from camera because don't have permission to access, browser not support or something went wrong.
                        </p>
                        <p>
                            <b style="font-size:20px;padding-top:10px;">You can upload image file at below.</b>
                        </p>
                    </div>
                    <video id="video" class="camera-view">Video stream not available.</video>
                    <div class="camera-control">
                        <button id="startbutton" class="btn btn-success">Take photo</button>
                        <input type="submit" id="submitbutton" class="btn btn-success" value="Upload!">
                    </div>
                </div>
            </div>
            <canvas id="canvas" style="display:none">
            </canvas>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Upload image by file</h1>
            <div class="card">
                <form id="camera_form" action="{{ url('upload/image') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    insert your image:<br>
                    <input type="file" name="picture" accept="image/*"><br>
                    <input type="hidden" id="base_picture" name="base_picture">
                    <input type="submit" class="btn btn-success" value="Upload!">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
