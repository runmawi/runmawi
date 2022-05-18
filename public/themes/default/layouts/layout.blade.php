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

        .circle {
               
                stroke-dasharray: 650;
                stroke-dashoffset: 650;
                -webkit-transition: all 0.5s ease-in-out;
                opacity: 0.3;
                stroke: {{ button_bg_color() .'!important' }} ;
        }

        .playbtn:hover .triangle {
                stroke-dashoffset: 0;
                opacity: 1;
                animation: trailorPlay 0.7s ease-in-out;
                stroke: {{ button_bg_color() .'!important' }} ;
        }

        i.ri-settings-4-line.text-primary {
            color: {{ button_bg_color() .'!important' }} ;
        }

        i.ri-logout-circle-line.text-primary{
            color: {{ button_bg_color() .'!important' }} ;
        }

        /* Home page Admin icon */
        .st0{
            fill:{{ button_bg_color() .'!important' }} ;
             stroke: {{ button_bg_color() .'!important' }} ;
        }
        .st0 {
            stroke-width: 0.75;
            stroke-miterlimit: 10;
            fill: {{ button_bg_color() .'!important' }} ;
            stroke: {{ button_bg_color() .'!important' }} ;
         }
        .st1 {
            stroke-width: 0.5;
            stroke-miterlimit: 10;
            fill:{{ button_bg_color() .'!important' }} ;
            stroke:{{ button_bg_color() .'!important' }} ;
         }
        .st2{
            fill:{{ button_bg_color() .'!important' }} ;
        }
         .st3{
           stroke: {{ button_bg_color() .'!important' }} ;
        }
        .st4{
             stroke:{{ button_bg_color() .'!important' }} ;
        }
        .st5{fill:{{ button_bg_color() .'!important' }} ;
        }
        
        .st6{fill:none;
             stroke-width:3;
             stroke-linecap:round;
             stroke-linejoin:round;
             stroke:{{ button_bg_color() .'!important' }}
            }
    </style>

</html>
