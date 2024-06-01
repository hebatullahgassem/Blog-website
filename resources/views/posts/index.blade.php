@extends('layouts.app')

@section('title') index @endsection

@section('content')
      <div class="text-center">
        <a href="{{route('posts.create')}}" class="btn btn-success">Create Post</a>
      </div>

      <table class="table w-75 mt-4 mx-auto">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Posted By</th>
              <th scope="col">Created At</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($posts as $post)
            <tr>
              <td scope="row">{{$post->id}}</td>
              <td>{{$post->title}}</</td>
              <td>{{$post->user ? $post->user->name : 'notfound'}}</</td>
              <td>{{$post->created_at}}</</td>
              <td>
                <a href="{{route('posts.show', $post->id)}}" class="btn btn-info">View</a>
                <a href="{{route('posts.edit', $post->id)}}" class="btn btn-primary">Edit</a>
                <form method="POST" action="{{route('posts.destroy', $post->id)}}" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure you want to delete this post?');">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
@endsection