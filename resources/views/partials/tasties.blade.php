@if($tasties > 0)
    <span class="badge  badge-success">
@elseif($tasties < 0)
    <span class="badge badge-danger">
@else
    <span class="badge badge-secondary">
@endif
    <span class="tasty_stat">{{ $tasties }}</span>
    <span> tasties</span>
</span>
