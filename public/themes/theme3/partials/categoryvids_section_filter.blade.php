@php
    $category_id = App\VideoCategory::where('name', $categoryVideos['category_title'])
    ->pluck('id')
    ->first();
@endphp

<div class="row mt-2 p-0 justify-content-end">

    {{-- <div class="col-md-2 col-sm-4 mb-1">
        <select class="selectpicker " multiple title="Refine" data-live-search="true">
            <option value="videos">Movie</option>
            <option value="tv_Shows">TV Shows</option>
            <option value="live_stream">Live stream</option>
            <option value="audios">Audios</option>
        </select>
    </div> --}}

    <div class="col-md-2  col-sm-4 mb-1">
        <select class="selectpicker " multiple title="Age" name="age[]" id="age" data-live-search="true">
            @foreach ($categoryVideos['age_categories'] as $age)
                <option value="{{ $age->age }}">{{ $age->slug }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2  col-sm-4 mb-1">
        <select class="selectpicker " multiple title="Rating" id="rating" name="rating[]" data-live-search="true">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>


    <div class="col-md-2 mb-1">
        <select class="selectpicker " multiple title="Newly added First" id="sorting" name="sorting"
            data-live-search="true">
            <option value="latest_videos">Latest Videos</option>
        </select>
    </div>

    <input type="hidden" id="category_id" value={{ $category_id }} name="category_id">

    <div class="col-md-1 text-right p-0" id="mob1">
        <button type="submit" class="btn btn-primary filter">Filter</button>
    </div>
</div>