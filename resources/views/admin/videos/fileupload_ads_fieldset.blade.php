
<fieldset>
   <div class="form-card">

      <div class="row">
            
         <div class="col-7"> <h2 class="fs-title">ADS Management:</h2> </div>

         <div class="col-sm-6 form-group mt-3">                       
            <label> {{ ucwords( 'Advertisement Devices' ) }}  </label>
            <select name="ads_devices[]" class="ads_devices" style="width:100%" multiple="multiple">
               <option value="website" > {{ ucwords('website') }} </option>
               <option value="android" > {{ ucwords('android') }} </option>
               <option value="IOS"     > {{ ucwords('IOS') }} </option>
               <option value="TV"      > {{ ucwords('TV') }} </option>
               <option value="roku"    > {{ ucwords('roku') }} </option>
               <option value="lg"      > {{ ucwords('lg') }} </option>
               <option value="samsung" > {{ ucwords('samsung') }} </option>
            </select>
         </div>

         <div id="accordionExample" class="accordion col-md-12">

                           {{-- Website --}}

               <button type="button" data-toggle="collapse" data-target="#website-ads-div" aria-expanded="true" 
                  class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link website-ads-button">
                  website
               </button>
      
               <div id="website-ads-div" data-parent="#accordionExample" class="row  collapse " >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="Website">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">                        {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre & post Position Advertisement' ) }}  </label>
                        <select class="form-control" name="video_js_pre_position_ads" >
                           <option value=" " > Select the Pre & Post Position Advertisement </option>
                           <option value="random_ads"> Random Ads </option>

                           @foreach ($video_js_Advertisements as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        
                        </select>
                     </div>

                  </div>
               
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="video_js_mid_position_ads_category" >
         
                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"  > Random Category </option>
         
                           @foreach( $ads_category as $ads_category )
                              <option value="{{ $ads_category->id }}"   > {{ $ads_category->name }}</option>
                           @endforeach
                        </select>
                     </div>
         
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time" value="" >
                     </div>
                  </div>
               </div>

               
               
                           {{-- Andriod --}}

               <button type="button" data-toggle="collapse" data-target="#Andriod-ads-div" aria-expanded="false"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Andriod-ads-button">Andriod 
               </button>
         
               <div id="Andriod-ads-div" data-parent="#accordionExample" class="row collapse"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="Andriod">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="andriod_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%android%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="andriod_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random"  > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%android%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"> {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="andriod_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"   > Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}"> {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="andriod_mid_sequence_time"  placeholder="HH:MM:SS"  id="andriod_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>

                           {{-- IOS --}}

               <button type="button" data-toggle="collapse" data-target="#IOS-ads-div" aria-expanded="false"
                  aria-controls="collapseThree"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link IOS-ads-button">IOS
               </button>

               <div class=" row  collapse" data-parent="#accordionExample" id="IOS-ads-div"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="IOS">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="ios_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>
                           
                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%IOS%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="ios_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%IOS%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="ios_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"  > Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}" > {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="ios_mid_sequence_time"  placeholder="HH:MM:SS"  id="ios_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>

                           {{-- TV --}}

               <button type="button" data-toggle="collapse" data-target="#TV-ads-div" aria-expanded="false"
                  aria-controls="collapseFour"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link TV-ads-button"
                  >TV
               </button>

               <div class="row collapse" data-parent="#accordionExample" id="TV-ads-div"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="TV">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="tv_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random"  > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%TV%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="tv_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%TV%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="tv_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"  > Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}"  > {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="tv_mid_sequence_time"  placeholder="HH:MM:SS"  id="tv_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>

                           {{-- Roku --}}

               <button type="button" data-toggle="collapse" data-target="#Roku-ads-div" aria-expanded="false"
                  aria-controls="collapseFive"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Roku-ads-button"
                  >Roku
               </button>
                                       
               <div class="row collapse" data-parent="#accordionExample" id="Roku-ads-div"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="Roku">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="roku_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random"> Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%roku%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="roku_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random"  > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%roku%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="roku_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"> Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}" > {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="roku_mid_sequence_time"  placeholder="HH:MM:SS"  id="roku_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>

                           {{-- LG --}}

               <button type="button" data-toggle="collapse" data-target="#LG-ads-div" aria-expanded="false"
                  aria-controls="collapseFive"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link LG-ads-button"
                  >LG
               </button>
            
               <div class="row collapse" data-parent="#accordionExample" id="LG-ads-div"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="LG">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="lg_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%lg%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="lg_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random"  > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%lg%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}" > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="lg_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category"   > Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}"  > {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="lg_mid_sequence_time"  placeholder="HH:MM:SS"  id="lg_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>

                           {{-- Samsung --}}

               <button type="button" data-toggle="collapse" data-target="#Samsung-ads-div" aria-expanded="false"
                     aria-controls="collapseFive"
                     class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Samsung-ads-button"
                     >Samsung
               </button>

               <div class="row  collapse" data-parent="#accordionExample" id="Samsung-ads-div"  >

                  <div class="col-md-12">
                     <hr class="hr-text" data-content="Samsung">
                  </div>

                  <div class="col-md-12 row">

                     <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                        <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                        <select class="form-control" name="samsung_vj_pre_postion_ads" >

                           <option value=" " > Select the Pre-Position Advertisement </option>
                           <option value="Random"  > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%samsung%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                        <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                        <select class="form-control" name="samsung_vj_post_position_ads" >

                           <option value=" " > Select the Post-Position Advertisement </option>
                           <option value="Random" > Random Ads </option>

                           @foreach ( App\Advertisement::where('status', 1)->where('ads_devices', 'like', '%samsung%')->get() as $video_js_Advertisement)
                              <option value="{{ $video_js_Advertisement->id }}"  > {{ $video_js_Advertisement->ads_name }}</option>
                           @endforeach
                        </select>
                     </div>

                  </div>
                  
                  <div class="col-md-12 row">
                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                        <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                        <select class="form-control" name="samsung_vj_mid_ads_category" >

                           <option value=" " > Select the Mid-Position Advertisement Category </option>
                           <option value="random_category" > Random Category </option>


                           @foreach( $advertisements_category as $ads_categories )
                              <option value="{{ $ads_categories->id }}"  > {{ $ads_categories->name }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                        <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                        <input type="text" class="form-control" name="samsung_mid_sequence_time"  placeholder="HH:MM:SS"  id="samsung_mid_sequence_time" value="" >
                     </div>
                  </div>
               </div>
         </div>
      </div>

      @if(isset($video->id))
         <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
      @endif

      <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
      <input type="hidden" id="video_id" name="video_id" value="">
      <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
      <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
      <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">
</div> 

   <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
   <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
</fieldset>