<style>
   textarea.form-control{
        border: none!important;
        border-radius: 5px;
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

    #emoji-button {
            position: absolute;
            right: 5px;
            top: 3px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
        }

      /* Responsive adjustments */
      @media (max-width: 600px) {
            .emoji-picker {
                top: 40px;
                left: 0;
                right: 0;
                width: 100%;
                margin-top: 35%;
                margin-left: 7%;
            }
        }

        @media (max-width: 400px) {
            .emoji-picker {
                top: 40px;
                left: 0;
                right: 0;
                width: auto;
                margin-top: 50%;
                margin-left: 25%;
            }
        }

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-button@4.6.2/dist/index.min.css">


<?php if(Auth::guest() != true): ?>

    <div class="mt-4 p-0">
        <div class="">
            <form method="get" action="<?= route('comments.store') ?>">
                <div class="row align-items-end">
                    <div class="col-lg-6">
                        <div class="form-group">
                    <label for="message" class="text-white">Add a comment:</label>
                    <div style=" position: relative;">
                    <textarea class="form-control"  name="message" rows="2" required></textarea>
                    <button type="button" id="emoji-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-emoji-laughing" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M12.331 9.5a1 1 0 0 1 0 1A5 5 0 0 1 8 13a5 5 0 0 1-4.33-2.5A1 1 0 0 1 4.535 9h6.93a1 1 0 0 1 .866.5M7 6.5c0 .828-.448 0-1 0s-1 .828-1 0S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 0-1 0s-1 .828-1 0S9.448 5 10 5s1 .672 1 1.5"/>
                      </svg></button>
                    </div>
                </div>

                    </div>
                    <div class="col-lg-6" style="margin-bottom: 1rem;">
                         
                <input type="hidden" name="source" value="<?= Route::currentRouteName() ?>">
                <input type="hidden" name="source_id" value="<?= $source_id ?>">

                <button type="submit" class=" btn btn-sm bd">Submit</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>

    <br />
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script>
    const button = document.querySelector('#emoji-button');

    const picker = new EmojiButton({
                position: 'left-start',
                autoHide: false,
            });


    button.addEventListener('click', () => {
    picker.togglePicker(button);
    });

    picker.on('emoji', emoji => {
    document.querySelector('textarea').value += emoji;
  });

  picker.on('picker', pickerEl => {
                pickerEl.classList.add('emoji-picker');
            });


</script>