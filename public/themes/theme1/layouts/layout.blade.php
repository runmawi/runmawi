
@content()



{{-- <!DOCTYPE html>
<html lang="en">

    <head>
        {!! meta_init() !!}
        <meta name="keywords" content="@get('keywords')">
        <meta name="description" content="@get('description')">
        <meta name="author" content="@get('author')">
    
        <title>@get('title')</title>

        @styles()
        
    </head>

    <body>
        @partial('header')

        @content()

        @partial('footer')

        @scripts()
    </body>

</html> --}}

<style>

    /*Button Bg color  */
    button.btn.signup {
            border: #f3ece0 !important ;
            background-color: {{ button_bg_color() .'!important' }} ;
        }

        button.transpar {
            border: #f3ece0 !important ;
            background-color:  {{ button_bg_color() .'!important' }} ;
        }

        button.btn.btn-primary{
            border: #f3ece0 !important ;
            background-color:  {{ button_bg_color() .'!important' }} ;
        }

        i.ri-settings-4-line.text-primary {
            color: {{ button_bg_color() .'!important' }} ;
        }

        i.ri-logout-circle-line.text-primary{
            color: {{ button_bg_color() .'!important' }} ;
        }

</style>