@include('header')

<div class="container">
@foreach($parentCategories as $category)
 <div class="row">
  <h2 style="color:#fff;">{{ __($category->name) }}</h2>

  @if(count($category->subcategory))
    @include('subChannelList',['subcategories' => $category->subcategory])
  @endif
 </div>
   
@endforeach
</div>

