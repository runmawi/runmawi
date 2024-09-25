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
    
    
    #myTextarea {
    max-height: 150px !important; 
    resize: vertical;
    }
    .emojionearea-button-open{
        visibility: hidden;
    }

    .emojionearea-button-close{
        visibility: hidden;
    }

    .emoji-button {
            position: absolute;
            right: 2px;
            top: 0;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color:grey;
        }

      .emojionearea-editor{
        color: #7f7f7f !important;
      }
      
      .emojionearea-picker{
        height: 300px !important; 
        overflow-y: auto;
      }
      
      .emojionearea .emojionearea-search input[type="text"] {
      visibility: hidden;
    }


</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emojionearea/dist/emojionearea.min.css">
<script src="https://cdn.jsdelivr.net/npm/emojionearea/dist/emojionearea.min.js"></script>

<div class="mt-4 p-0">
    <div class="">
        <form method="get" action="<?= route('comments.store') ?>">
            <div class="row align-items-end align-items-center">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="message" class="text-white">Add a comment:</label>
                        <div style=" position: relative;">
                            <textarea id="myTextarea" class="form-control"  name="message" rows="2" required></textarea>
                            <button type="button"  class="emoji-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#7f7f7f" class="bi bi-emoji-laughing" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M12.331 9.5a1 1 0 0 1 0 1A5 5 0 0 1 8 13a5 5 0 0 1-4.33-2.5A1 1 0 0 1 4.535 9h6.93a1 1 0 0 1 .866.5M7 6.5c0 .828-.448 0-1 0s-1 .828-1 0S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 0-1 0s-1 .828-1 0S9.448 5 10 5s1 .672 1 1.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-right" >     
                <input type="hidden" name="source" value="<?= Route::currentRouteName() ?>">
                <input type="hidden" name="source_id" value="<?= $source_id ?>">
                <button type="submit" class=" btn btn-primary text-uppercase" style="margin:10px 0 10px 0; border-radius: 5px!important;">Submit</button>
            </div>

        </form>
    </div>
</div>

    <br />

    <script>
        jQuery(document).ready(function($) {
            $('#myTextarea').emojioneArea({
                pickerPosition: 'bottom',
                tonesStyle: 'radio',
                autocomplete: false,
            });
        });
    
          function hideEmojiPicker() {
                    emojiPicker[0].emojioneArea.hidePicker();
                }
    
                $(document).on('click', function(event) {
                    var pickerContainer = $('.emojionearea-picker');
                    if (pickerContainer.is(':visible')) {
                        hideEmojiPicker();
                    }
                });
    
                $(document).on('click', '.emojionearea', function(event) {
                    hideEmojiPicker();
                });
    
    </script>
    