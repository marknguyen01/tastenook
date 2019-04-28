@extends('layouts/app')

@section('content')
    <div class="container">
        <h3>Create a business</h3>
        <form method="POST" action="{{ route('business.store') }}">
            <div class="form-row form-group">
                <div class="col-lg-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="col-lg-6">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug">
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col-6">
                    <label for="street">Street address</label>
                    <input type="text" class="form-control" id="street" name="street">
                </div>
                <div class="col-lg-2 col-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="col-lg-2 col-6">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state">
                </div>
                <div class="col-lg-2 col-6">
                    <label for="zip">Zip</label>
                    <input type="number" class="form-control" id="zip" name="zip">
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col-lg-6">
                    <label for="phone">Phone Number</label>
                    <input type="number" class="form-control" id="phone" name="phone">
                </div>
                <div class="col-lg-6">
                    <label for="website">Website</label>
                    <input type="url" class="form-control" id="website" name="website">
                </div>
            </div>
            @csrf
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
