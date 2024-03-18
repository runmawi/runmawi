<style>
   .hr-text {
      line-height: 1em;
      position: relative;
      outline: 0;
      border: 0;
      color: black;
      text-align: center;
      height: 1.5em;
      opacity: .5;
      &:before {
         content: '';
         background: linear-gradient(to right, transparent, #818078, transparent);
         position: absolute;
         left: 0;
         top: 50%;
         width: 100%;
         height: 1px;
      }
      &:after {
         content: attr(data-content);
         position: relative;
         display: inline-block;
         color: black;
         padding: 0 .5em;
         line-height: 1.5em;
         color: #818078;
         background-color: #fcfcfa;
      }
   }
</style>


<fieldset id="ads_data">

   <div class="form-card">
      <div class="row">
         <div class="col-md-7"> <h2 class="fs-title">ADS Management:</h2> </div>

         <div class="col-sm-6 form-group mt-3">                       
            <label> {{ ucwords( 'Advertisement Devices' ) }}  </label>
            <select name="ads_devices[]" class="ads_devices" style="width:100%" multiple="multiple">
               <option value="website" @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'website',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif > {{ ucwords('website') }} </option>
               <option value="android" @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'android',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif  > {{ ucwords('android') }} </option>
               <option value="IOS"     @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'IOS',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif> {{ ucwords('IOS') }} </option>
               <option value="TV"      @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'TV',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif> {{ ucwords('TV') }} </option>
               <option value="roku"    @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'roku',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif> {{ ucwords('roku') }} </option>
               <option value="lg"      @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'lg',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif> {{ ucwords('lg') }} </option>
               <option value="samsung" @if ( !is_null( $admin_videos_ads ) && !is_null( $admin_videos_ads->ads_devices ) &&  in_array( 'samsung',json_decode( $admin_videos_ads->ads_devices)) ) selected="true" @endif> {{ ucwords('samsung') }} </option>
            </select>
         </div>
      </div>
    
                              {{-- Video.Js Player--}}

      @if( choosen_player() == 1  )   

            
         <div id="accordionExample" class="accordion">
             
                                          {{-- Website --}}

            <button type="button" data-toggle="collapse" data-target="#website-ads-div" aria-expanded="true" 
               class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link website-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('website', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}" >
               website
            </button>
   
            <div id="website-ads-div" data-parent="#accordionExample" class="row collapse " >

               <div class="col-md-12">
                  <hr class="hr-text" data-content="Website">
               </div>

               <div class="col-md-12 row">

                  <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                     <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                     <select class="form-control" name="video_js_pre_position_ads" >
      
                        <option value=" " > Select the Pre-Position Advertisement </option>
                        <option value="random_ads" {{  ( $video->video_js_pre_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['website'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  ( $video->video_js_pre_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="video_js_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  ( $video->video_js_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['website'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  ( $video->video_js_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
            
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="video_js_mid_position_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  ( $video->video_js_mid_position_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      
                        @foreach( $ads_category as $ads_category )
                           <option value="{{ $ads_category->id }}"  {{  ( $video->video_js_mid_position_ads_category == $ads_category->id ) ? 'selected' : '' }} > {{ $ads_category->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="video_js_mid_advertisement_sequence_time"  placeholder="HH:MM:SS"  id="video_js_mid_advertisement_sequence_time" value="{{ $video->video_js_mid_advertisement_sequence_time }}" >
                  </div>
               </div>
            </div>

                                          {{-- Andriod --}}
               
            <button type="button" data-toggle="collapse" data-target="#Andriod-ads-div" aria-expanded="false"
               class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Andriod-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('android', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">Andriod 
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
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->andriod_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['android'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->andriod_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="andriod_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->andriod_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['android'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->andriod_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="andriod_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->andriod_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      

                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->andriod_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="andriod_mid_sequence_time"  placeholder="HH:MM:SS"  id="andriod_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->andriod_mid_sequence_time : null }}" >
                  </div>
               </div>
            </div>
              
                                          {{-- IOS --}}

            <button type="button" data-toggle="collapse" data-target="#IOS-ads-div" aria-expanded="false"
               aria-controls="collapseThree"
               class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link IOS-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('IOS', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">IOS
            </button>

            <div class=" collapse" data-parent="#accordionExample" id="IOS-ads-div"  >

               <div class="col-md-12">
                  <hr class="hr-text" data-content="IOS">
               </div>

               <div class="col-md-12 row">

                  <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                     <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                     <select class="form-control" name="ios_vj_pre_postion_ads" >
      
                        <option value=" " > Select the Pre-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->ios_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['IOS'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->ios_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="ios_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->ios_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['IOS'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->ios_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="ios_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->ios_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      

                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) && ( $admin_videos_ads->ios_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="ios_mid_sequence_time"  placeholder="HH:MM:SS"  id="ios_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->ios_mid_sequence_time : null }}" >
                  </div>
               </div>
            </div>

                                           {{-- TV --}}

            <button type="button" data-toggle="collapse" data-target="#TV-ads-div" aria-expanded="false"
               aria-controls="collapseFour"
               class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link TV-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('TV', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">TV
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
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->tv_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['TV'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->tv_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="tv_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->tv_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['TV'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->tv_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="tv_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->tv_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      

                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) && ( $admin_videos_ads->tv_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="tv_mid_sequence_time"  placeholder="HH:MM:SS"  id="tv_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->tv_mid_sequence_time : null }}" >
                  </div>
               </div>
            </div>

                                           {{-- Roku --}}

            <button type="button" data-toggle="collapse" data-target="#Roku-ads-div" aria-expanded="false"
               aria-controls="collapseFive"
               class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Roku-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('roku', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">Roku
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
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->roku_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['roku'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->roku_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="roku_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->roku_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['roku'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{ !is_null( $admin_videos_ads ) &&  ( $admin_videos_ads->roku_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="roku_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->roku_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      

                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) && ( $admin_videos_ads->roku_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="roku_mid_sequence_time"  placeholder="HH:MM:SS"  id="roku_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->roku_mid_sequence_time : null }}" >
                  </div>
               </div>
            </div>

                                          {{-- LG --}}

            <button type="button" data-toggle="collapse" data-target="#LG-ads-div" aria-expanded="false"
               aria-controls="collapseFive"
               class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link LG-ads-button"
               style="display: {{ !is_null($admin_videos_ads) && in_array('lg', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">LG
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
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['lg'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="lg_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['lg'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>

               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="lg_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      

                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) && ( $admin_videos_ads->lg_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="lg_mid_sequence_time"  placeholder="HH:MM:SS"  id="lg_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->lg_mid_sequence_time : null }}" >
                  </div>
               </div>
            </div>

                                          {{-- Samsung --}}

            <button type="button" data-toggle="collapse" data-target="#Samsung-ads-div" aria-expanded="false"
                  aria-controls="collapseFive"
                  class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link Samsung-ads-button"
                  style="display: {{ !is_null($admin_videos_ads) && in_array('samsung', json_decode($admin_videos_ads->ads_devices)) ? 'block-inline' : 'none' }}">Samsung
            </button>

            <div class="row collapse" data-parent="#accordionExample" id="Samsung-ads-div"  >

               <div class="col-md-12">
                  <hr class="hr-text" data-content="Samsung">
               </div>
   
               <div class="col-md-12 row">
   
                  <div class="col-sm-6 form-group mt-3">           {{-- Pre-Advertisement --}}
                     <label> {{ ucwords( 'Choose the Pre-Position Advertisement' ) }}  </label>
                     <select class="form-control" name="samsung_vj_pre_postion_ads" >
      
                        <option value=" " > Select the Pre-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_pre_postion_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['samsung'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_pre_postion_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Post-Advertisement--}}
                     <label> {{ ucwords( 'Choose the Post-Position Advertisement' ) }}    </label>
                     <select class="form-control" name="samsung_vj_post_position_ads" >
      
                        <option value=" " > Select the Post-Position Advertisement </option>
                        <option value="random_ads" {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_post_position_ads == "random_ads" ) ? 'selected' : '' }} > Random Ads </option>
      
                        @foreach ( $vj_Ads_devices->whereJsonContains('ads_devices',['samsung'])->get() as $video_js_Advertisement)
                           <option value="{{ $video_js_Advertisement->id }}"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_post_position_ads == $video_js_Advertisement->id ) ? 'selected' : '' }} > {{ $video_js_Advertisement->ads_name }}</option>
                        @endforeach
                     </select>
                  </div>
   
               </div>
               
               <div class="col-md-12 row">
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement--}}
                     <label> {{ ucwords( 'choose the Mid-Position Advertisement Category' ) }}  </label>
                     <select class="form-control" name="samsung_vj_mid_ads_category" >
      
                        <option value=" " > Select the Mid-Position Advertisement Category </option>
                        <option value="random_category"  {{  !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_mid_ads_category == "random_category" ) ? 'selected' : '' }} > Random Category </option>
      
   
                        @foreach( $advertisements_category as $ads_categories )
                           <option value="{{ $ads_categories->id }}"  {{ !is_null( $admin_videos_ads ) && ( $admin_videos_ads->samsung_vj_mid_ads_category == $ads_categories->id ) ? 'selected' : '' }} > {{ $ads_categories->name }}</option>
                        @endforeach
                     </select>
                  </div>
      
                  <div class="col-sm-6 form-group mt-3">            {{-- Mid-Advertisement sequence time--}}
                     <label> {{ ucwords( 'Mid-Advertisement Sequence Time' ) }}   </label>
                     <input type="text" class="form-control" name="samsung_mid_sequence_time"  placeholder="HH:MM:SS"  id="samsung_mid_sequence_time" value="{{ !is_null( $admin_videos_ads ) ? $admin_videos_ads->samsung_mid_sequence_time : null  }}" >
                  </div>
               </div>
            </div>
         </div>

      @else                           {{-- Plyr.io Player --}}
         <div class="row">
            <div class="col-sm-6 form-group mt-3">                        {{-- Ads Category--}}
               <label class="">Choose the Ads Position</label>
               <select class="form-control" name="tag_url_ads_position" id="tag_url_ads_position">
                  <option value=" ">Select the Ads Position </option>
                  <option value="pre"  @if(($video->tag_url_ads_position != null ) && $video->tag_url_ads_position == 'pre'){{ 'selected' }}@endif >  Pre-Ads Position</option>
                  <option value="mid"  @if(($video->tag_url_ads_position != null ) && $video->tag_url_ads_position == 'mid'){{ 'selected' }}@endif >  Mid-Ads Position</option>
                  <option value="post" @if(($video->tag_url_ads_position != null ) && $video->tag_url_ads_position == 'post'){{ 'selected' }}@endif > Post-Ads Position</option>
                  <option value="all"  @if(($video->tag_url_ads_position != null ) && $video->tag_url_ads_position == 'all'){{ 'selected' }}@endif >   All Ads Position</option>
               </select>
            </div>

            <div class="col-sm-6 form-group mt-3" id="ads_tag_url_id_div" >   {{-- Ads --}}
               <label class="">Choose Advertisement</label>
               <select class="form-control" name="ads_tag_url_id" id="ads_tag_url_id">
                  @if( $ads_tag_urls != null)
                     <option id="" value="{{ $ads_tag_urls->id   }} " {{ 'selected' }} > {{ $ads_tag_urls->ads_name  }} </option>
                  @else
                     <option value=" ">Select the Advertisement</option>
                  @endif
               </select>
            </div>
         </div>
      @endif

      <div class="row">

         @if($page == 'Edit' && $video->status == 0)
            <div class="col-7">
               <h2 class="fs-title">Transcoding:</h2>
            </div>
         @endif

         <div class="col-sm-6 form-group mt-3">
            <div id="success"></div>

            <div class="row text-center">
               <input type="hidden" id="page" value="{{ $page }}">
               
               @if(isset($video->id))
                  <input type="hidden" id="status" value="{{ $video->status }}">
               @else
                  <input type="hidden" id="status" value="0">
               @endif

               @if($page == 'Create' || $page == 'Edit')
             
               @endif

               @if($page == 'Edit' && $video->status == 0 && $video->type != 'embed' && $video->type != 'mp4_url' && $video->type != 'm3u8_url')
               <br><br><br>
               <div class="col-sm-12">
                  Video Transcoding is under Progress
                  <div class="progress">
                     <div class="low_bar"></div >
                  </div>
                  <div class="low_percent">0%</div >
               </div>
               @endif
            </div>
         </div>
      </div>

      @if(isset($video->id))
         <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
         <input type="hidden" id="publish_status" name="publish_status" value="{{ $video->publish_status }}" >
         <input type="hidden" id="type" name="type" value="{{ $video->type }}" />                               
      @endif

      <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
      <input type="hidden" id="selectedImageUrlInput" name="selected_image_url" value="">
      <input type="hidden" id="videoImageUrlInput" name="video_image_url" value="">
      <input type="hidden" id="SelectedTVImageUrlInput" name="selected_tv_image_url" value="">
   </div>

   <button type="submit" class="btn btn-primary mr-2" value="{{ $button_text }}">{{ $button_text }}</button>
   <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
</fieldset>
