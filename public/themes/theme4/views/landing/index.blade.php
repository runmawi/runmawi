<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $title ? $title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>

                            {{-- Boostrap --}}
         <?php  echo  $bootstrap_link ;  ?>
         
                            {{--Google fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
                
                            {{-- Favicon icon --}}
        <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

                            {{-- custom css --}}
        <?php  echo  ( $custom_css);  ?>
        
    </head>

    <body>

            {{-- Header --}}
        @if ( $header == 1)
            @php include(public_path('themes/theme4/views/header.php'))  @endphp 
        @endif

                {{-- Section 1 --}}
        @foreach ($sections_1 as $key => $section_1)

            @php echo html_entity_decode($section_1) @endphp

        @endforeach

                {{-- Section 2 --}}

        @foreach ($sections_2 as $section_2)

             @php echo html_entity_decode($section_2) @endphp
            
        @endforeach

                {{-- Section 3 --}}
        @foreach ($sections_3 as $section_3)

             @php echo html_entity_decode($section_3) @endphp
            
        @endforeach

                    {{-- Section 4  --}}
        @foreach ($sections_4 as $section_4)

            @php echo html_entity_decode($section_4) @endphp
            
        @endforeach

       <script>
            document.write("<?php echo ( $script_content); ?>");
        </script>

                {{-- Footer --}}
        @if ( $footer == 1)
          @php include(public_path('themes/theme4/views/footer.blade.php')); @endphp 
        @endif

    </body>
</html>
