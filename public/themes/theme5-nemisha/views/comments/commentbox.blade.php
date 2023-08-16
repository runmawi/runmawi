<style>
   textarea.form-control{
         border: none!important;
    border-bottom: 1px solid #fff!important;
       line-height: 25px;
    }
   
    .form-control:focus{
        box-shadow: none;
    }
    .bg-border{
       
        border-radius: 5px;
        padding: 10px;
    }
    .media-body{
        padding: 10px;
    }
    .btn-sm{
        padding: 10px 25px;
    border-radius: 30px;
    }
    a{
        cursor: pointer;
    }
    .form-control{
        background-color: #141414!important;
    }
    .edu{
     
        padding: 2px 5px;
        font-size: 16px;
        
    }
    .dele{
        padding: 2px 5px;
          font-size: 18px;
    }
    .modal.form-control{
        color:#000;
    }
    .rep{
        padding-left: 15px;
    }
</style>
<div class="mt-4 p-0">
        <div class="">
            <form method="get" action="<?= route('comments.store') ?>">
                <div class="row align-items-end align-items-center">
                    <div class="col-lg-6">
                        <div class="form-group">
                    <label for="message" class="text-white">Add a comment:</label>
                    <textarea class="form-control"  name="message" rows="2" required></textarea>
                </div>
</div>
                    </div>
                    <div class="col-lg-6 text-right" >
                         
                <input type="hidden" name="source" value="<?= Route::currentRouteName() ?>">
                <input type="hidden" name="source_id" value="<?= $source_id ?>">

                <button type="submit" class=" btn btn-primary text-uppercase" style="margin:10px 0 10px 0;border-radius: 5px!important;">Submit</button>
                    </div>
                
               
            </form>
        </div>
    </div>

    <br />