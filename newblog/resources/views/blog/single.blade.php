@extends('main')

@section('title', '| $post->title')

@section('content')

   <div class="row">
     <div class="col-md-8 col-md-offset-2">
       <img src="{{ asset('images/'.$post->image) }}" height="400" width="400">
       <div class="text-center">
         <h1>{{ $post->title }}</h1>
         <p>{{ $post->body }}</p>
         <hr>
         <p>Posted In: {{ $post->category->name }}</p>
       </div>
     </div>
   </div>

@endsection
