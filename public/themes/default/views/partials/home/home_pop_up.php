<?php 
    $AdminHomePopup = App\AdminHomePopup::first();
    $enable_popup = App\AdminHomePopup::pluck('popup_enable')->first();
    $auth_user_role    = Auth::user() ? Auth::user()->role : "guest"; 
    $auth_guest_user    = Auth::guest(); 
?>

<!-- Pop-up modal -->
    <div class="modal fade bd-example-modal-md" id="pop_up" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
                            <!-- Close button -->
            <button type="button" class="btn-close" disabled aria-label="Close"> X </button>
            
            <div class="modal-content pop_content row">
                <a href="<?php echo URL::to('/becomesubscriber') ; ?>" >
                            <!-- Pop-up Image  -->
                    <img src="<?= $AdminHomePopup ?  URL::to('public/images/'. $AdminHomePopup->popup_image ) : URL::to('public/images/'); ?>" class="w-100"  >
                            
                            <!-- pop-up content  -->
                    <div>
                        <h1 class="pop_up_content">   <?= $AdminHomePopup ? $AdminHomePopup->popup_header : ' '; ?> </h1>
                        <h5 class="pop_up_content">   <?= $AdminHomePopup ? $AdminHomePopup->popup_content : " ";?>  </h5>
                        <h3 class="pop_up_content">   <?= $AdminHomePopup ? $AdminHomePopup->popup_content : " ";?>  </h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
   

<script>

    $(window).on('load', function() {
        var pop_up_enable =  <?php  echo ( $enable_popup); ?>; 
        var auth_user_role  = <?php  echo json_encode($auth_user_role); ?>; 
        var auth_guest_user =  <?php  echo json_encode( $auth_guest_user); ?>; 

        if( pop_up_enable == 1 ){
            if(  auth_guest_user == true || auth_user_role == "registered"){
                $('#pop_up').modal('show');
            }
        }
    });

</script>

<style>
    .pop_up_content {
        position: absolute;
        transform: translate(-50%, -50%);
        color: #181717;
    }

    .category-heading{
        float: right;
    }
    
    .btn-close{
        font-weight: 700;
        color: red;
        background-color: transparent;
        border: none;
        position: absolute;
        top: 2%;
        right: 1%;
    }
   
    .modal-dialog {
        max-width: 600px!important;
        margin: 2.00rem auto!important;
    }
</style>