<div class="col-12 col-md-4">
    <div class="business row py-3">
        <div class="col-lg-6 col-12 order-md-1 order-2 business-info">
            <h4><a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
            {{ $business->name }}
            </a></h4>
            <div class="business-rating">
                @for($i = 0; $i < round($business->rating_avg, 0); $i++)
                    <i class="fas fa-star"></i>
                @endfor

                @for($i = 0; $i < (5 - round($business->rating_avg, 0)); $i++)
                    <i class="far fa-star"></i>
                @endfor
            </div>
            <span class="business-status">Open {{ time_elapsed_string($business->created_at) }}</span>
            <div class="business-stats">
                <span class="view-count"><i class="fas fa-eye"></i> {{ $business->view_count }}</span>
                <span class="review-count"><i class="fas fa-star"></i> {{ $business->review_count }}</span>
            </div>
        </div>
        <div class="col-lg-6 col-12 order-md-2 order-1 business-img text-center">
            <a href="/b/{{ $business->slug }}" alt="{{ $business-> name}}">
                <img src="{{ $business->avatar }}" alt="{{ $business->name }}" class="img-fluid">
            </a>
        </div>
    </div>
</div>
