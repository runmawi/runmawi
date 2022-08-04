<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{  $title ? $title.' | '.GetWebsiteName() : 'Landing-page'.' | '.GetWebsiteName() }}</title>

                    {{--style Page  --}}
        @php include(public_path('themes/default/views/landing/landing_style.blade.php')); @endphp

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
