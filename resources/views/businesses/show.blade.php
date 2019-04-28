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
                <div class="profile__rating rating">
                    @include('partials/rating', ['rating' => $business->rating_avg])
                </div>
                <div class="btn-group profile__action" role="group" aria-label="Basic example">
                @auth
                  @allowed('review.businesses', $user_review)
                    <a href="#reviews__form" class="btn btn-danger py-2">Edit your review</a>
                  @else
                    <a href="#reviews__form" class="btn btn-danger py-2">Leave your review</a>
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
                    @if($coupons)
                    <div class="col-12 mt-3">
                        <ul class="list-group">
                          @foreach($coupons as $coupon)
                          <li class="list-group-item">
                              <p>
                                  {{ $coupon->name }}
                                   <span class="badge badge-danger badge-pill">expires in {{ time_left_string($coupon->expired_at) }}</span>
                               </p>
                              <p><strong>{{ $coupon->code }}</strong></p>
                              @if($coupon->description)
                                  <p><small>*{{ $coupon->description }}</small></p>
                              @endif
                          </li>
                          @endforeach
                        </ul>
                    </div>
                @endif
                </div>
            </div>
        </div>
        @allowed('edit.businesses', $business)
        <div class="profile__admin my-3">
          <a href="/b/{{ $business->slug }}/edit" class="btn btn-outline-success">Manage your business</a>
          <a href="/b/{{ $business->slug}}/coupon/create" class="btn btn-outline-success">Manage coupons</a>
        </div>
        @endallowed
        <div class="profile__posts">
            <ul class="list-group mt-3">
                <h3 class="list-group-item p-3">Owner's Posts</h3>
                <li class="list-group-item post">
                    <div class="row">
                      <div class="col-md-4 col-lg-2 col-sm-12 post__avatar text-center">
                            <a href="/b/{{ $business->slug }}" alt="{{ $business->name }}" class="d-block">
                                <img src="{{ asset($business->avatar) }}" alt="{{ $business->name }}" class="img-fluid rounded">
                                <h4>{{ $business->name }}</h4>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-10 col-sm-12">
                              <div class="posts__date">Posted 4 days ago</div>
                            <div class="posts__content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                            <div class="posts__actions mt-2">
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
                    @include('businesses/create-review')
                  @else
                    Please <a href="/login">login</a> to leave a review
                  @endauth
                </li>
                @foreach ($reviews as $review)
                <li class="list-group-item review">
                    <div class="row">
                        <div class="col-md-4 col-lg-2 col-sm-12 review__avatar text-center">
                            <a href="/profile/{{ $review->user->name }}" alt="{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] }}" class="d-block">
                                <img src="{{ asset($review->user->profile->avatar ) }}" alt="{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] }}" class="img-fluid rounded">
                                <h4>{{ $review->user->first_name . ' ' . ($review->user->last_name)[0] . '.' }}</h4>
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-10 col-sm-12">
                            <div class="review__rating rating">
                                @include('partials/rating', ['rating' => $review->rating])
                            </div>
                            <div class="reviews__date">{{ time_elapsed_string($review->created_at) }}</div>
                            <div class="reviews__content">{{ $review->content }}</div>
                            <div class="reviews__actions mt-2">
                                @include('businesses/profile-actions', [
                                  'upvote_route' => route('review.upvote', $review->id),
                                  'upvote_count' => $review->countUpVoters(),
                                  'downvote_route' => route('review.downvote', $review->id),
                                  'downvote_count' => $review->countDownVoters(),
                                  'comment_route' => route('review.comment', $review->id),
                                ])
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
@endsection
