<button class="btn btn-outline-success action" onclick="UserAction.sendRequest(this, '{{ $upvote_route }}')">
  <i class="fas fa-thumbs-up"></i>
  <span class="d-none d-md-inline">
    (<span class="upvote_stat">{{ isset($upvote_count) ? $upvote_count : 0 }}</span>) TASTY</span>
</button>
<button class="btn btn-outline-danger action"
onclick="UserAction.sendRequest(this, '{{ $downvote_route }}')">
  <i class="fas fa-thumbs-down"></i>
  <span class="d-none d-md-inline">(<span class="downvote_stat">{{ isset($downvote_count) ? $downvote_count : 0 }}</span>) EWWW
</span>
</button>
@auth
@if(isset($comment_route))
<button class="btn btn-outline-secondary action"
onclick="UserAction.createCommentForm(this, '{{ $comment_route }}')">
  <i class="fas fa-comment"></i>
  <span class="d-none d-md-inline">
    (<span class="comment_stat">{{ isset($comment_count) ? $comment_count : 0 }}</span>) COMMENT
  </span>
</button>
@endif
@endauth
