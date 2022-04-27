@php
   $favicon_icon = App\Setting::pluck('favicon')->first();
@endphp

<head>
    <!-- Favicon -->
   <link rel="shortcut icon" href="<?= URL::to('/'). '/public/uploads/settings/' . $favicon_icon; ?>" />
</head>