<form class="my-3" method="post" action="{{ $route }}">
    @csrf
    <textarea type="text" class="form-control mb-2 mr-sm-2 w-100" rows="2" placeholder="Enter your post" name="content">
    </textarea>
    <button type="submit" class="btn btn-dark mb-2">POST</button>
    <div class="form-check form-check-inline float-right">
        <input type='hidden' value='0' name='as_user'>
        <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="as_user">
        <label class="form-check-label" for="defaultCheck1">
            Post as user?
        </label>
    </div>
</form>
