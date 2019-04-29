@extends('layouts/app')
@section('content')
<div class="container">
    <h3>All coupons</h3>
    <div class="table-responsive p-2 p-lg-3" style="background: white">
        <a href="{{ route('coupon.create', $business->slug) }}" class="btn btn-dark my-3">New coupon</a>
        @if(!$business->coupons->isEmpty())
        <table class="table table-striped table-sm data-table">
            <thead class="thead">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Expired at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($business->coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->description }}</td>
                    <td>{{ $coupon->expired_at }}</td>
                    <td>
                        <a class="btn btn-danger" href="{{ route('coupon.delete', [
                            'slug' => $coupon->business->slug,
                            'coupon_id' => $coupon
                        ]) }}">Delete</a>
                        <a class="btn btn-info" href="{{ route('coupon.edit', [
                            'slug' => $coupon->business->slug,
                            'coupon_id' => $coupon
                        ]) }}">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>No coupon to show</p>
        @endif
    </div>
</div>
@endsection
