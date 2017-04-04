@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')
   {!! Html::style('css/select2.min.css') !!}
@endsection

@section('content')

<form method="POST" action="{{ route('posts.update', $post->id) }}">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label for="title">Title:</label>
            <textarea type="text" class="form-control input-lg" id="title" name="title" rows="1" style="resize:none;">{{ $post->title }}</textarea>
          </div>

          <div class="form-group">
            <label for="slug">Slug:</label>
            <textarea type="text" class="form-control input-lg" id="slug" name="slug" rows="10">{{ $post->slug }}</textarea>
          </div>

          <label for="category_id">Category:</label>
          <select class="form-control" name="category_id">
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>

          <label for="tags">Tags:</label>
          <select class="form-control select2-multi" name="tags[]" multiple="multiple">
            @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
          </select>

          <div class="form-group ">
            <label for="body" class="form-spacing-top">Body:</label>
            <textarea type="text" class="form-control input-lg " id="body" name="body" rows="10">{{ $post->body }}</textarea>
          </div>
        </div>

        <div class="col-md-4">
          <div class="well">
            <dl class="dl-horizontal">
              <dt>Created at:</dt>
              <dd>{{ date('M j, Y h:i:sa', strtotime($post->created_at)) }}</dd>
            </dl>

            <dl class="dl-horizontal">
              <dt>Last updated:</dt>
              <dd>{{ date('M j, Y h:i:sa', strtotime($post->updated_at)) }}</dd>
            </dl>
            <hr>

            <div class="row">
              <div class="col-sm-6">
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-danger btn-block">Back</a>
              </div>

              <div class="col-md-6">
                <button type="submit" class="btn btn-success btn-block">Save</button>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              {{ method_field('PUT') }}
              </div>
            </div>
          </div>
        </div>
      </div>
</form>﻿

@stop

@section('scripts')
  {!! Html::script('js/select2.min.js') !!}

  <script type="text/javascript">
    $('.select2-multi').select2();
    $('.select2-multi').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
  </script>
@endsection
