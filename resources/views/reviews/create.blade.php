@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="my-5">Create a review for {{ $business->name }}</h3>
  {!! Form::open(['route' => ['review.store', $business->slug], 'method' => 'POST']) !!}
  {!! csrf_field() !!}
  <div class="form-group has-feedback {{ $errors->has('rating') ? ' has-error ' : '' }}">
    {!! Form::label('rating', 'Rating' , array('class' => 'control-label')); !!}
    <div class="rating">
      <label>
        <input type="radio" name="rating" value="5" title="5 stars"> 5
      </label>
      <label>
        <input type="radio" name="rating" value="4" title="4 stars"> 4
      </label>
      <label>
        <input type="radio" name="rating" value="3" title="3 stars"> 3
      </label>
      <label>
        <input type="radio" name="rating" value="2" title="2 stars"> 2
      </label>
      <label>
        <input type="radio" name="rating" value="1" title="1 star"> 1
      </label>
    </div>
    @if ($errors->has('rating'))
    <span class="help-block">
      <strong>{{ $errors->first('rating') }}</strong>
    </span>
    @endif
  </div>
  <div class="form-group has-feedback {{ $errors->has('content') ? ' has-error ' : '' }}">
    {!! Form::label('content', 'Your review' , array('class' => 'control-label')); !!}
    {!! Form::textarea('content', old('content'), array('id' => 'notes', 'class' => 'form-control', 'placeholder' => 'Enter your review')) !!}
    @if ($errors->has('content'))
    <span class="help-block">
      <strong>{{ $errors->first('content') }}</strong>
    </span>
    @endif
  </div>
  {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add review', array('class' => 'btn btn-success btn-block mb-0','type' => 'submit', )) !!}
  {!! Form::close() !!}
</div>


@endsection
