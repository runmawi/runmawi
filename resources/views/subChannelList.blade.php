
<?php if (count($subcategories) == 0 ) { ?>

  <h2><?php echo __('No Video Found');?> </h2>
<?php } else  { ?> 

@foreach($subcategories as $subcategory)

<!--    <li style="list-style:none;">{{$subcategory->name}}</li> -->
     
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 new-art">
            <article class="block expand">
                <a class="block-thumbnail" href="<?php echo URL::to('/').'/category/'.$subcategory->id;?>">
                   
                    <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$subcategory->image;?>">
                </a>
               <div class="block-contents">
                    <p class="movie-title padding"><?php echo __($subcategory->name);?></p>
                </div>
            </article>
        </div>
     
      @if(count($subcategory->subcategory))
        @include('subChannelList',['subcategories' => $subcategory->subcategory])
      @endif
@endforeach

<?php } ?>