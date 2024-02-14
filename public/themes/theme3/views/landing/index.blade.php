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
    <style>
        body{
            background-color: #000;
        }
        .text-white{
            color: #fff;
            text-align:center;
            font-size:40px;
            margin: 0;
        }
        .col-4.col-sm-4 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sec-2{
            margin-top:13em;
        }
        .align-self-center img{
            width:20%;
        }
        .doc-rec{
            margin-bottom: 15em;
        }
        @media (max-width:768px){
            .text-white{
                font-size:30px;
            }
            .sec-2{
                margin-top:0;
            }
            .align-self-center img{
                width:25%;
            }
            .sec-2{
                margin-top:7em;
            }
        }
        @media (max-width:618px){
            .text-white{
                font-size:20px;
            }
            .sec-2{
                margin-top:4em;
            }
            .doc-rec{
                margin-bottom: 8em;
            }
        }
        @media (max-width:425px){
            .text-white{
                font-size:15px;
            }
        }
        @media (max-width:320px){
            .text-white{
                font-size:13px;
            }
        }
    </style>

    <body>



    <div class="container sec-2">
        <div class="row">
            <div class="col-4 col-sm-4"></div>
            <div class="col-4 col-sm-4">
                <img src="<?php echo URL::to('/assets/img/Holding-Page.jpg'); ?>" alt="img" style="width:100%;">
                <h1 class="text-white m-0">Made by Music fans for Music fans</h1>
            </div>
            <div class="col-4 col-sm-4"></div>
        </div>
        
    </div>
    <div class="container text-center sec-2">
        <div class="row">
            <div class="col align-self-center" style="text-align:center;">
                <img src="<?php echo URL::to('/assets/img/Holding_page-timer.jpg'); ?>" alt="img" >
                <h1 class="text-white" style="margin:0;color:#f500c8;">The countdown will soon begin...</h1>
                <h1 class="text-white" style="margin:0;color:#f500c8;">... and then all will be revealed.</h1>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="container sec-2 doc-rec">
        <p class="text-white">What are those Document Records People up to?</p>
    </div>

            {{-- Header --}}
        @if ( $header == 1)
            @php include(public_path('themes/theme3/views/header.php'))  @endphp 
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
          @php include(public_path('themes/theme3/views/footer.blade.php')); @endphp 
        @endif

    </body>
</html>
