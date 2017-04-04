
@extends('main')
@section('title', '| Contact')
@section('content')
  <div class="row">
    <div class="col-md-8">
      <h1>Contact me</h1>
      <hr>
      <form class="" action="{{ url('contact') }}" method="post">
         {{ csrf_field() }}
        <div class="form-group">
          <label name="email">Email:</label>
          <input id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
          <label name="subject">Subject:</label>
          <input id="subject" name="subject" class="form-control">
        </div>

        <div class="form-group">
          <label name="message">Message:</label>
          <textarea id="message" name="message" class="form-control">Type your text here...</textarea>
        </div>

        <input type="submit" value="Send Message" class="btn btn-success">
      </form>
    </div>
  </div>
@endsection
