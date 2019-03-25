<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <meta name="description" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link href="{{ asset('/css/welcome.css') }}" rel="stylesheet">

    <style type="text/css">
        @yield('template_fastload_css')

        @if (Auth::User() && Auth::User()->profile)
        .user-avatar-nav {
            background: url('{{ Auth::User()->profile->avatar }}') 50% 50% no-repeat;
            background-size: auto 100%;
        }
        @endif

    </style>

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">

    <header id="intro">
        <div class="container">
            <div class="row">
                <div id="navbar" class="col-12 align-self-start mt-5">
                    <div class="row">
                        <div class="col-4" id="brand-name">
                            <h2>{!! config('app.name', trans('titles.app')) !!}</h2>
                        </div>
                        <div class="col-8 d-flex" id="user-info">
                        @guest
                            <span class="ml-auto">
                                <a href="{{ route('login') }}" class="nav-link mr-3">{{ trans('titles.login') }}</a>
                                <a href="{{ route('register') }}" class="nav-link">{{ trans('titles.register') }}</a>
                            </span>
                        @else
                            <div class="nav-item dropdown ml-auto">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->firstName . ' ' . Auth::user()->lastName }}">
                                    <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span> <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}">
                                        {!! trans('titles.profile') !!}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                        </div>
                    </div>
                </div>
                <div id="search" class="col-12 align-self-start mt-5">
                    <div class="input-group">
                          <input class="form-control py-2" type="search" placeholder="Looking for a restaurant?" name="search">
                          <div class="input-group-append" id="search-separator">
                              <span></span>
                          </div>
                          <input class="form-control" type="text" placeholder="Enter your location" name="location">
                          <div class="input-group-append">
                            <button class="btn" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
      <div id="new-businesses" class="businesses pb-3 pb-lg-5">
          <h2 class="text-center business-heading my-3 my-lg-5">New Restaurants in Charlotte</h2>
          <div class="row p-3 p-lg-0">
              @foreach ($newBusinesses as $business)
                <div class="col-12 col-md-4">
                    <div class="business row py-3">
                        <div class="col-6 business-info">
                            <h4><a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
                            {{ $business->name }}
                            </a></h4>
                            <div class="business-rating">
                                @for($i = 0; $i < round($business->vote_avg, 0); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor

                                @for($i = 0; $i < (5 - round($business->vote_avg, 0)); $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                            <span class="business-status">Open {{ time_elapsed_string($business->created_at) }}</span>
                        </div>
                        <div class="col-6 business-img">
                            <a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
                                <img src="{{ $business->avatar }}" alt="{{ $business->name }}">
                            </a>
                        </div>
                    </div>
                </div>
              @endforeach
          </div>
      </div>
      <div id="hot-businesses" class="businesses pb-3 pb-lg-5">
          <h2 class="text-center business-heading my-3 my-lg-5">Hot Restaurants in Charlotte</h2>
          <div class="row p-3 p-lg-0">
              @foreach ($hotBusinesses as $business)
                <div class="col-12 col-md-4">
                    <div class="business row py-3">
                        <div class="col-6 business-info">
                            <h4><a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
                            {{ $business->name }}
                            </a></h4>
                            <div class="business-rating">
                                @for($i = 0; $i < round($business->vote_avg, 0); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor

                                @for($i = 0; $i < (5 - round($business->vote_avg, 0)); $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                            <span class="business-status">Open {{ time_elapsed_string($business->created_at) }}</span>
                        </div>
                        <div class="col-6 business-img">
                            <a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
                                <img src="{{ $business->avatar }}" alt="{{ $business->name }}">
                            </a>
                        </div>
                    </div>
                </div>
              @endforeach
          </div>
      </div>
    </div>

    </div>

    {{-- Scripts --}}
    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('footer_scripts')

</body>
</html>
