@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Create coupon</h3>
        <div id="reviews__form" class="my-3">
          <form method="post" action="{{ isset($coupon) ? route('coupon.update', [$coupon->business->slug, $coupon]) : route('coupon.store', $business->slug) }}">
            @csrf
            <div class="form-row mb-2">
                <div class="col-6">
                    <input type="text" name="name" class="form-control"
                    placeholder="{{ isset($coupon) ? "" : "Enter coupon name"}}" value="{{ isset($coupon) ? $coupon->name : ""}}" required></input>
                </div>
                <div class="col-3">
                    <input type="text" name="code" class="form-control"
                    placeholder="{{ isset($coupon) ? "" : "Enter coupon code"}}" value="{{ isset($coupon) ? $coupon->code : ""}}" required></input>
                </div>
                <div class="col-3">
                    <input type="date" name="expired_at" class="form-control"
                    placeholder="{{ isset($coupon) ? "" : "Enter expiration date"}}" value="{{ isset($coupon) ? $coupon->expired_at : ""}}" required></input>
                </div>
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control" rows="2"
                placeholder="{{ isset($coupon) ? "" : "Enter coupon description"}}">{{ isset($coupon) ? $coupon->description : ""}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($coupon) ? "Save" : "Create" }}</button>
          </form>
        </div>
    </div>
@endsection
