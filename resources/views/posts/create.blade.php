@extends('layouts.app')

@section('title') create @endsection

@section('content')
{{-- to display error message --}}
{{-- The title field is required. --}}
@if ($errors->any())

<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
  
@endif

{{-- method takes the request type that you will submit  --}}
{{-- action takes the url that you will submit the form to it --}}
<form class="container" method="POST" action="{{route('posts.store')}}">
  {{-- to fix page expired error when submitting the form and redirecting to main page --}}
  @csrf
  <div class="mt-3">
    <label for="inputEmail4" class="form-label">Title</label>
    {{-- to improve user experience, show the old value after submitting if there is an error(value="{{old('title')}}") --}} 
    <input name="title" type="text" class="form-control" id="inputEmail4" value="{{old('title')}}">
  </div>
  <div class="mt-3">
    <label for="inputPassword4" class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-control">{{old('description')}}</textarea>
  </div>
  <div class="mt-3">
    <label for="inputState" class="form-label">Post Creator</label>
    <select name="postCreator" id="inputState" class="form-select">
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