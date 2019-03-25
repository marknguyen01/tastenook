@extends('layouts.app')

@section('template_linked_fonts')
<link href="https://fonts.googleapis.com/css?family=Lobster|Roboto:400,700" rel="stylesheet">
@endsection


@section('content')
<div class="profile">
    <!-- TODO: Change image to company's cover picture. -->
    <!-- TODO: Add a default cover picture incase the company doesn't have one set. -->
    <img src="{{ asset('images/businesses/profile/' . $business->slug . '/cover.jpg') }}" class="profile__cover">
    <div class="profile__content">
        <div class="profile__picture">
            <!-- TODO: Change image to company's profile picture. -->
            <img src="{{ asset($business->avatar) }}">
        </div>
        <div class="profile__title">
            <!-- TODO: Change text to the company's name. -->
            <h1>{{ $business->name }}</h1>
            <!-- TODO: Add logic to change icon based on if the company is favorited. -->
            <!--    If the company is favorited, change from "far fa-heart" to "fas fa-heart" -->
            <i class="far fa-heart"></i>
        </div>
        <div class="profile__picture--shadow">
            <!-- This is just for effect. -->
        </div>

        <!-- START PROFILE NAV PARTIAL -->
        <nav class="profile__nav">
            <div class="profile__rating">
                @for($i = 0; $i < round($business->vote_avg, 0); $i++)
                    <i class="fas fa-star"></i>
                @endfor

                @for($i = 0; $i < (5 - round($business->vote_avg, 0)); $i++)
                    <i class="far fa-star"></i>
                @endfor
            </div>
            <ul>
                <!-- TODO: Add logic to determine which nav link is .active -->
                <li><a href="" class="active">Profile</a></li>
                <li><a href="">Reviews (504)</a></li>
                <li><a href="">Menu</a></li>
                <li><a href="">Locations</a></li>
                <li><a href="">Gallery</a></li>
                <li><button class="default-modal__trigger">Contact</a></li>
            </ul>
        </nav>
        <!-- END PROFILE NAV PARTIAL -->

        <div class="profile__info">

            <!-- Within this profile info div on the profile page, the company's -->
            <!--    latest posts will be shown.  The posts use the same exact    -->
            <!--    HTML as the posts from the dashboard, so once the logic is   -->
            <!--    added on those, you can simply copy and paste it over here.  -->
            <!--                                                                 -->
            <!-- The post that is below is just to show what it'll look like on  -->
            <!--    the page and where the posts will go.                        -->

            <div class="default-post">
                <!-- TODO: Set link to the company's profile page. -->
                <a class="default-post__image" href="#">
                    <!-- TODO: Set image source to company's profile image. -->
                    <img src="{{ asset($business->avatar)}}">
                </a>
                <div class="default-post__poster">
                    <!-- TODO: Set link below to company's profile page. -->
                    <!-- TODO: Set text below to company's name. -->
                    <a href="#">McDonald's</a>
                </div>
                <div class="default-post__posttime">
                    <!-- TODO: Set text below to how long ago post was made. -->
                    24 Minutes Ago
                </div>
                <div class="default-post__content">
                    <hr class="default-divider">
                    <!-- TODO: Set text below to the body of the post. -->
                    <p>Test test test</p>
                    <hr class="default-divider">
                </div>
                <div class="default-post__interactions">
                    <button class="default-post__interactions-group">
                        <i class="fas fa-thumbs-up"></i>
                        <!-- TODO: Set text in span to number of upvotes. -->
                        <span class="default-post__interactions-number">2.4k</span>
                    </button>
                    <button class="default-post__interactions-group">
                        <i class="fas fa-thumbs-down"></i>
                        <!-- TODO: Set text in span to number of downvotes. -->
                        <span class="default-post__interactions-number">203</span>
                    </button>
                    <button class="default-post__interactions-group">
                        <i class="fas fa-comment"></i>
                        <!-- TODO: Set text in span to number of comments. -->
                        <span class="default-post__interactions-number">34</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal default-modal default-modal--contact">
    <div class="default-modal__content default-modal__content--contact">
        <div class="default-modal__header">
            <!-- TODO: Change text to reflect company's name. -->
            <h2>Contact McDonald's</h2>
            <span class="default-modal__close">&times;</span>
        </div>
        <hr class="gradient-divider">
        <!-- TODO: Change action to route for contacting company. -->
        <form class="default-form" method="POST" action="/">
            <!-- This hidden field below is the parameter for the company.  -->
            <!--    The value would be how the company will be identified   -->
            <!--    on the backend.  Right now I have it as the company's   -->
            <!--    name, but it may very well make more sense to have it   -->
            <!--    be the company's database ID.                           -->
            <!-- TODO: Verify name attribute matches backend variable name. -->
            <input type="hidden" name="company" value="McDonald's">
            <div class="default-form__input-group">
                <!-- TODO: Verify name attribute matches backend variable name. -->
                <input class="default-form__text-input" type="text" name="subject" placeholder="Subject">
            </div>
            <div class="default-form__textarea">
                <!-- TODO: Verify name attribute matches backend variable name. -->
                <textarea name="message" placeholder="Write your message here..."></textarea>
            </div>
            <hr class="default-divider">
            <div class="default-form__button-group">
                <input type="submit" value="Send" class="bubble-button--med">
            </div>
        </form>
    </div>
</div>
@endsection


@section('footer_scripts')

@endsection
