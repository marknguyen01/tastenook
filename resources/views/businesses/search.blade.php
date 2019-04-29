@extends('layouts.app')
@section('template_linked_css')
<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container">
    <div class="businesses pb-3 pb-lg-5">
        <h2 class="text-center business-heading my-3 my-lg-5">Restaurants in {{ $city }}, {{ $state }}</h2>
        <div class="row p-3 p-lg-0">
            @if($businesses)
                @foreach($businesses as $b)
                    @include('businesses/business-panel', [
                    'business' => $b,
                    ])
                @endforeach
            @else
                <div class="alert alert-light w-100 text-center" role="alert">
                    No restaurants found
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
