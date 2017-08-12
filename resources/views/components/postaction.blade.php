<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><a href="{{ url('posts/'.$post->id.'/edit') }}">Edit</a></li>
    <li><a class="delete-menu" href="{{ url('posts/'.$post->id.'/delete') }}">Delete</a></li>
  </ul>
</div>