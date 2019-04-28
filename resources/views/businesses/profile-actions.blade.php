<button class="btn btn-success action" onclick="UserAction.sendRequest(this, '{{ $upvote_route }}')">
  <i class="fas fa-thumbs-up"></i>
  <span class="d-none d-md-inline">
    (<span class="action__stats">{{ isset($upvote_count) ? $upvote_count : 0 }}</span>) LIKE</span>
</button>
<button class="btn btn-danger action"
onclick="UserAction.sendRequest(this, '{{ $downvote_route }}')">
  <i class="fas fa-thumbs-down"></i>
  <span class="d-none d-md-inline">(<span class="action__stats">{{ isset($downvote_count) ? $downvote_count : 0 }}</span>) DISIKE
</span>
</button>
<button class="btn btn-secondary action"
onclick="UserAction.sendRequest(this, '{{ $comment_route }}')">
  <i class="fas fa-comment"></i>
  <span class="d-none d-md-inline">
    (<span class="action__stats">{{ isset($comment_count) ? $comment_count : 0 }}</span>) COMMENT
  </span>
</button>
