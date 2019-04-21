<div class="rating__wrap">
    <span class="stars--active" style="width:{{ round($rating, 2) * 20 }}%">
    @for($i = 0; $i < 5; $i++)
        <i class="fas fa-star"></i>
    @endfor
    </span>
    <span class="stars--inactive">
        @for($i = 0; $i < 5; $i++)
            <i class="far fa-star"></i>
        @endfor
    </span>
</div>
