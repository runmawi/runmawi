<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $title ? $title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>

                            {{-- Boostrap --}}
        <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />

                            {{--Google fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800&display=swap" rel="stylesheet">
                
                            {{-- Favicon icon --}}
        <link rel="shortcut icon" href="<?php echo getFavicon();?>" type="image/gif" sizes="16x16">

                            {{-- custom css --}}
        <?php  echo  preg_replace("/\r|\n/", "", $custom_css);  ?>
        
    </head>

    <body>

                {{-- Section 1 --}}
        @forelse ($sections_1 as $key => $section_1)

            @php echo html_entity_decode($section_1) @endphp
        @empty

        @endforelse


                {{-- Section 2 --}}

        @forelse ($sections_2 as $section_2)

             @php echo html_entity_decode($section_2) @endphp

        @empty
            
        @endforelse

                {{-- Section 3 --}}
        @forelse ($sections_3 as $section_3)

             @php echo html_entity_decode($section_3) @endphp

        @empty
            
        @endforelse

                    {{-- Section 4  --}}
        @forelse ($sections_4 as $section_4)

            @php echo html_entity_decode($section_4) @endphp

        @empty
            
        @endforelse

    </body>
</html>
