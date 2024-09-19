<style>
   textarea.form-control{
        border: none!important;
        line-height: 25px;
        height: 70px;
        border-radius: 7px;
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
        background-color: #fff!important;
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


<div class="px-2">
        <div class="">
            <form method="get" action="<?= route('comments.store') ?>">
                <div class="form-group">
                    <div style=" position: relative;">
                    <textarea id="myTextarea" class="form-control" placeholder="Add a comment" name="message" rows="2" required></textarea>

                    </div>
                </div>
                <div class=" text-right" >
                    <input type="hidden" name="source" value="<?= Route::currentRouteName() ?>">
                    <input type="hidden" name="source_id" value="<?= $source_id ?>">
                    <button type="submit" id="submit" style="display: none;" class=" btn btn-primary text-uppercase" style="margin:10px 0 10px 0; border-radius: 5px!important;">Submit</button>
                </div>
            </form>
        </div>
</div>

    <br />

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('myTextarea');
        const submitButton = document.getElementById('submit');
    
        input.addEventListener('input', function() {
            const value = this.value;
            if (value.length > 0) {
                submitButton.style.display = 'inline';
            } else {
                submitButton.style.display = 'none';
            }
        });

    });

</script>