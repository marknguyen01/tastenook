@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $business->name }} Details</h3>
    <form method="POST" action="{{ route('business.update', $business->slug) }}">
        <div class="form-row form-group">
            <div class="col-lg-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $business->name }}">
            </div>
            <div class="col-lg-6">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ $business->slug }}">
            </div>
        </div>
        <div class="form-row form-group">
            <div class="col-6">
                <label for="street">Street address</label>
                <input type="text" class="form-control" id="street" name="street" value="{{ $business->street_address }}">
            </div>
            <div class="col-lg-2 col-6">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $business->city }}">
            </div>
            <div class="col-lg-2 col-6">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" value="{{ $business->state }}">
            </div>
            <div class="col-lg-2 col-6">
                <label for="zip">Zip</label>
                <input type="number" class="form-control" id="zip" name="zip" value="{{ $business->zip_code }}">
            </div>
        </div>
        <div class="form-row form-group">
            <div class="col-lg-6">
                <label for="phone">Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" value="{{ $business->phone_number }}">
            </div>
            <div class="col-lg-6">
                <label for="website">Website</label>
                <input type="url" class="form-control" id="website" name="website" value="{{ $business->website }}">
            </div>
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('business.show', $business->slug ) }}" class="btn btn-danger">Go back</a>
    </form>
</div>
@endsection
