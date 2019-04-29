<form class="search-bar form-inline my-2 my-lg-0" action="{{ route('business.search') }}" method="post">
    @csrf
    <div class="input-group">
          <input class="form-control py-2" type="search" placeholder="Looking for a restaurant?" name="search" value="{{
          isset($search_name) ? $search_name : ""}}">
          <div class="input-group-append" id="search-separator">
              <span></span>
          </div>
          <input class="form-control" type="text" placeholder="Enter your location" name="location"
          value="{{ isset($search_location) ? $search_location : ""}}"required>
          <div class="input-group-append">
            <button class="btn" type="submit">
                <i class="fa fa-search"></i>
            </button>
          </div>
    </div>
</form>
