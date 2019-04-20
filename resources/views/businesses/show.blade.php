@extends('layouts.app')

@section('template_linked_fonts')
<link href="https://fonts.googleapis.com/css?family=Lobster|Roboto:400,700" rel="stylesheet">
@endsection


@section('content')
<div class="profile">
    <div class="carousel-slide container-fluid">
        <div class="row">
            @for($i = 0; $i < 4; $i++)
                <div class="col-lg-3 col-md-6 col-sm-12 mx-0 px-0 {{ $i < 3 ? 'd-md-block d-none' : ''}}">
                    <img src="{{ asset('images/businesses/profile/' . $business->slug . '/cover.jpg') }}" class="w-100">
                    @if($i == 3)
                        <span class="carousel-slide__control p-2"><a href="/b/{{ $business->slug }}/gallery">View Gallery</a></span>
                    @endif
                </div>
            @endfor
        </div>
    </div>
    <div class="profile__content container">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="profile__title ">
                    <h1>{{ $business->name }}</h1>
                </div>
                <div class="profile__rating">
                    <h2>@for($i = 0; $i < round($business->rating_avg, 0); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                    @for($i = 0; $i < (5 - round($business->rating_avg, 0)); $i++)
                        <i class="far fa-star"></i>
                    @endfor</h2>
                </div>
                <div class="btn-group profile__action" role="group" aria-label="Basic example">
                @auth
                  @allowed('review.businesses', $business)
                    <a href="#reviews__form" class="btn btn-danger py-2">Leave a review</a>
                  @else
                    <a href="#reviews__form" class="btn btn-danger py-2">Leave a review</a>
                  @endallowed
                  <button type="button" class="btn btn-outline-secondary">Follow</button>
                  <button type="button" class="btn btn-outline-secondary">Message</button>
                @else
                    <button type="button" class="btn btn-outline-secondary">Share</button>
                @endauth
                </div>
                <div class="profile__maps mt-3">
                  <div id="map" class="h-100"></div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="row">
                    <div class="col-12 mt-3">
                        <ul class="list-group">
                          <li class="list-group-item">
                              <i class="fas fa-phone"></i>
                              <a href="tel:{{ $business->phone_number }}" alt="{{ $business->phone_number }}">{{ $business->phone_number }}</a>
                          </li>
                          <li class="list-group-item">
                              <i class="fas fa-map-marker-alt"></i>
                              <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($business->address) }}" alt="{{ $business->address}}">
                                  {{ $business->address }}
                              </a>
                          </li>
                          <li class="list-group-item">
                              <i class="fas fa-globe"></i>
                              <a href="{{ $business->website }}">{{ $business->name }} Website</a>
                          </li>
                        </ul>
                    </div>
                    <div class="col-12 mt-3">
                        <ul class="list-group">
                          <li class="list-group-item">
                              20% off on one burger
                               <span class="badge badge-danger badge-pill">HOT</span>
                               <span class="badge badge-success badge-pill">NEW</span>

                          </li>
                          <li class="list-group-item">
                              10% on any combo
                              <span class="badge badge-danger badge-pill">HOT</span>
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile__posts">
            <ul class="list-group mt-3">
                <h3 class="list-group-item p-3">Owner's Posts</h3>
                <li class="list-group-item">
                    <div class="row">
                      <div class="col-md-4 col-lg-2 col-sm-12 posts__avatar text-center">
                            <a href="/b/{{ $business->slug }}" alt="{{ $business->name }}" class="d-block">
                                <img src="{{ asset($business->avatar) }}" alt="{{ $business->name }}" class="img-fluid rounded">
                                <h4>{{ $business->name }}</h4>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-10 col-sm-12">
                              <div class="posts__date">Posted 4 days ago</div>
                            <div class="posts__content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                            <div class="posts__actions mt-2">
                                @include('businesses/profile-actions')
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="profile__reviews">
            <ul class="list-group mt-3">
                <li class="list-group-item p-3">
                  <h3>Reviews</h3>
                  @auth
                    @include('reviews/create')
                  @else
                    Please <a href="/login">login</a> to leave a review
                  @endauth
                </li>
                @foreach ($reviews as $review)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4 col-lg-2 col-sm-12 posts__avatar text-center">
                            <a href="/profile/{{ $review->user->name }}" alt="{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] }}" class="d-block">
                                <img src="{{ asset($review->user->profile->avatar ) }}" alt="{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] }}" class="img-fluid rounded">
                                <h4>{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] . '.' }}</h4>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-10 col-sm-12">
                            <div class="reviews__rating">
                              @for($i = 0; $i < $review->rating; $i++)
                                  <i class="fas fa-star"></i>
                              @endfor

                              @for($i = 0; $i < (5 - $review->rating); $i++)
                                  <i class="far fa-star"></i>
                              @endfor
                            </div>
                            <div class="reviews__date">{{ time_elapsed_string($review->created_at) }}</div>
                            <div class="reviews__content">{{ $review->content }}</div>
                            <div class="reviews__actions mt-2">
                                @include('businesses/profile-actions')
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection


@section('footer_scripts')
<script type="text/javascript">
var geopoints = {
  lat: {{ $business->lat }},
  lng: {{ $business->lng }}
}
</script>
<script src="{{ asset('js/business.js') }}" type="text/javascript"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config("settings.googleMapsAPIKey") }}&callback=initMap"></script>
<script type="text/javascript">
$('.form__rating input').change(function () {
  var $radio = $(this);
  $('.form__rating .selected').removeClass('selected');
  $radio.closest('label').addClass('selected');
});
</script>
@endsection
