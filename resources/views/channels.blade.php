@include('header')

<div class="container">
  @foreach($parentCategories as $category)
    <h2 style="color:#fff;">{{ __($category->name) }}</h2>
    <div class="d-flex mb-3">

      @if(count($category->subcategory))
      @include('subChannelList',['subcategories' => $category->subcategory])
      @endif
    </div>

  @endforeach
</div>