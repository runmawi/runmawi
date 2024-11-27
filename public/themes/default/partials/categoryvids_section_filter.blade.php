@php
    $category_id = App\VideoCategory::where('name', $categoryVideos['category_title'])
    ->pluck('id')
    ->first();
@endphp

<style>
    .bootstrap-select>.dropdown-toggle{
        background: transparent !important;
        border: 1px solid #ddd !important;
        border-radius: 10px !important;
        color: #fff !important;
    }
    body.light-theme .dropdown-menu{
      background-color: <?php echo GetLightBg(); ?>!important;  
      color: <?php echo GetLightText(); ?>!important;
      box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
    }
    .dropdown-menu{
        background-color: #000;
        color: #fff !important;
        box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
    }
    .dropdown-item:focus, .dropdown-item:hover{
        background-color: #000;
        color: #fff !important;
        box-shadow: rgb(0 0 0 / 16%) 0px 3px 10px;
    }
    li.no-results{
        color:#000 !important;
    }
    body.light-theme input{
        color: <?php echo GetLightText(); ?> !important;
    }
    .selectpicker{display: none;}
    @media (max-width:1200px){
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){width: 100% !important;}
    }

</style>

<div class="row m-0 p-0 justify-content-start">

    {{-- <div class="col-md-2 col-sm-4 mb-1">
        <select class="selectpicker " multiple title="Refine" data-live-search="true">
            <option value="videos">  {{ __('Movie') }}</option>
            <option value="tv_Shows">  {{ __('TV Shows') }}</option>
            <option value="live_stream">  {{ __('Live stream') }}</option>
            <option value="audios">  {{ __('Audios') }}</option>
        </select>
    </div> --}}

    <div class="col-lg-2 col-md-3 col-3 mb-1 p-0">
        <select class="selectpicker " multiple title="Age" name="age[]" id="age" data-live-search="true">
            @foreach ($categoryVideos['age_categories'] as $age)
                <option value="{{ $age->age }}">{{ $age->slug }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-2 col-md-3 col-3 mb-1 p-0">
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


    <div class="col-lg-2 col-md-4 col-3 mb-1 p-0">
        <select class="selectpicker " multiple title="Newly added First" id="sorting" name="sorting"
            data-live-search="true">
            <option value="latest_videos">  {{ __('Latest Videos') }}</option>
        </select>
    </div>

    <input type="hidden" id="category_id" value={{ $category_id }} name="category_id">

    <div class="col-lg-1 col-md-2 col-2 text-right p-0" id="mob1">
        <button type="submit" class="btn bd filter">  {{ __('Filter') }}</button>
    </div>
</div>