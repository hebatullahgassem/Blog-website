@extends('layouts.app')

@section('title') create @endsection

@section('content')

{{-- method takes the request type that you will submit  --}}
{{-- action takes the url that you will submit the form to it --}}
<form class="container" method="POST" action="{{route('posts.store')}}">
  {{-- to fix page expired error when submitting the form and redirecting to main page --}}
  @csrf
  <div class="mt-3">
    <label for="inputEmail4" class="form-label">Title</label>
    <input name="title" type="text" class="form-control" id="inputEmail4">
  </div>
  <div class="mt-3">
    <label for="inputPassword4" class="form-label">Description</label>
    <input name="description" type="text" class="form-control" id="inputPassword4">
  </div>
  <div class="mt-3">
    <label for="inputState" class="form-label">Post Creator</label>

    
    <select name="post_creator" id="inputState" class="form-select">
      @foreach ($users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
    </select>
    
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success mt-3">Submit</button>
  </div>
</form>

@endsection