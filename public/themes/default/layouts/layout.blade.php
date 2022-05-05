<!DOCTYPE html>
<html lang="en">

    <head>
        {!! meta_init() !!}
        <meta name="keywords" content="@get('keywords')">
        <meta name="description" content="@get('description')">
        <meta name="author" content="@get('author')">

    {{-- favicon --}}
    
        <link rel="shortcut icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">

        @styles()
        
    </head>

    <body>
        @partial('header')

        @content()

        @partial('footer')

        @scripts()
    </body>


    <style>

    /*Button Bg color  */
        button.btn.btn-hover.ab {
                border: #f3ece0 !important ;
                background-color: {{ button_bg_color() .'!important' }} ;
            }

        button.btn-hover:before {
                border: #f3ece0 !important ;
                background-color: {{ button_bg_color() .'!important' }} ;
            }
                /* sign up  */
        button.btn.btn-hover.btn-primary.btn-block.signup {
                border: #f3ece0 !important ;
                background-color: {{ button_bg_color() .'!important' }} ;
            }
                /* profile page */
        .btn{
            border: #f3ece0 !important ;
            background-color: {{ button_bg_color() .'!important' }} ;
        }
    
    </style>

</html>
