<div class="post__user col-md-4 col-lg-2 col-sm-12 text-center">
    <div class="post__user__avatar">
        <a href="{{ $user_route }}" class="d-block">
            <img src="{{ $user_avatar }}" alt="{{ $user_name }}" class="img-fluid rounded">
            <h4>{{ $user_name }}</h4>
        </a>
    </div>
    <div class="post__user__stats">
        @include('partials/tasties', [
        'tasties' => $user_tasties
        ])
    </div>
</div>
