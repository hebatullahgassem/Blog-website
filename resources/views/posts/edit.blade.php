@extends('layouts.app')

@section('title') edit @endsection

@section('content')

{{-- method takes the request type that you will submit  --}}
{{-- action takes the url that you will submit the form to it --}}
<form class="container" method="POST" action="{{route('posts.update', $post->id)}}">
  {{-- to fix page expired error when submitting the form and redirecting to main page --}}
  @csrf
  @method('PUT')
  {{-- we put this directive because form method doesnot support put/patch/delete --}}
  {{-- and if we let the method with put without using this directive it will throw an error 
    because the method that we put on the route is PUT  --}}
  {{-- now when i click on update it will take me to update route --}}
  <div class="mt-3">
    <label for="inputEmail4" class="form-label">Title</label>
    <input name="title" type="text" value="{{$post->title}}" class="form-control" id="inputEmail4">
  </div>
  <div class="mt-3">
    <label for="inputPassword4" class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{$post->description}}</textarea>
  </div>
  <div class="mt-3">
    <label for="inputState" class="form-label">Post Creator</label>
    <select name="postCreator" id="inputState" class="form-select">
      @foreach ($users as $user)
      {{-- to make the selected user selected in edit form --}}
      <option @if($user->id == $post->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary mt-3">Update</button>
  </div>
</form>

@endsection