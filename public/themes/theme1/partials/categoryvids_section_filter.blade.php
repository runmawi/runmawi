@php
    $category_id = App\VideoCategory::where('name', $categoryVideos['category_title'])
    ->pluck('id')
    ->first();
@endphp

<div class="row justify-content-end p-3 ">
    <div class="col-md-2 text-right p-0 Refine">
        <select class="selectpicker" multiple title="{{ __('Age') }}" name="age[]" id="age" data-live-search="true">
            @foreach ($categoryVideos['age_categories'] as $age)
                <option value="{{ $age->age }}">{{ $age->slug }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 text-right p-0 Refine">
        <select class="selectpicker" multiple title="{{ __('Rating') }}" id="rating" name="rating[]" data-live-search="true">
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


    <div class="col-md-2 text-right Refine p-0">
        <select class="selectpicker " multiple title="{{ __('Newly added First') }}" id="sorting" name="sorting"
            data-live-search="true">
            <option value="latest_videos">{{ __('Latest Videos') }}</option>
        </select>
    </div>

    <input type="hidden" id="category_id" value={{ $category_id }} name="category_id">

    <div class="col-md-1 text-right p-0 Refine">
        <button type="submit" class="btn btn-primary filter">{{ __('Filter') }}</button>
    </div>
</div>
