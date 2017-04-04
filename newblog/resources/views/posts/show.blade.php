@extends('main')

@section('title', '| View Post')

@section('content')

 <div class="row">
   <div class="col-md-8">
     <h1>{{ $post->title }}</h1>
     <p class="lead">{{ $post->body }}</p>

     <hr>

     <div class="tags">
       @foreach($post->tags as $tag)
          <span class="label label-default">{{ $tag->name }}</span>
       @endforeach
     </div>

     <hr>

     <div class="row">
       <div class="col-md-8 col-md-offset-2">
         <h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span>{{ $post->comments()->count() }} Comments</h3>
         @foreach($post->comments as $comment)
            <div class="comment">
              <div class="author-info">
                <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))).'?s=50&d=mm' }}" alt="" class="author-image">
                <div class="author-name">
                  <h4>{{ $comment->name }}</h4>
                  <p class="author-time">{{ date('F nS, Y - G:iA', strtotime($comment->created_at)) }}</p>
                </div>
              </div>

              <div class="comment-content">
                {{ $comment->comment }}
                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary" style="margin-left:20px;"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
              </div>
            </div>
         @endforeach
       </div>
     </div>

     <hr>

     <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top:50px;">
          {{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}

          <div class="row">
            <div class="col-md-6">
              {{ Form::label('name', "Name:") }}
              {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>

            <div class="col-md-6">
              {{ Form::label('email', "Email:") }}
              {{ Form::text('email', null, ['class' => 'form-control']) }}
            </div>

            <div class="col-md-12">
              {{ Form::label('comment', "Comment:") }}
              {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

              {{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
            </div>
          </div>
          {{ Form::close() }}
        </div>
     </div>
   </div>

   <div class="col-md-4">
     <div class="well">
       <dl class="dl-horizontal">
         <label>Url:</label>
         <p><a href="{{ url($post->slug) }}">{{url($post->slug)}}</a></p>
       </dl>

       <dl class="dl-horizontal">
         <label>Category:</label>
         <p>{{ $post->category->name }}</p>
       </dl>

       <dl class="dl-horizontal">
         <label>Last updated:</label>
         <p>{{ date('M j, Y H:ia', strtotime($post->updated_at)) }}</p>
       </dl>

       <hr>

       <div class="row">
         <div class="col-md-6">
           {!! Html::linkRoute('posts.edit', 'Edit', array($post->id), array('class' =>'btn btn-primary btn-block')) !!}
         </div>

         <div class="col-md-6">
           {!! Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'DELETE']) !!}
           {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-block']) !!}
           {!! Form::close() !!}
         </div>
       </div>

       <div class="row">
         <div class="col-md-12">
           {{ Html::linkRoute('posts.index', '<< See All Posts', [], ['class' => 'btn btn-default btn-block btn-h1-spacing'])}}
         </div>
       </div>

     </div>
   </div>
 </div>

@endsection
