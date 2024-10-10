@php
    $current_timezone = 'Asia/Kolkata';
    $current_time = Carbon\Carbon::now($current_timezone);
@endphp

<footer class="page-footer red">
    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <h5 class="white-text">About</h5>
                <p class="grey-text text-lighten-4">This portal is for content creators/providers in Runmawi app.
                </p>
            </div>
            <div class="col s12 m6">
                <h5 class="white-text">Customer Service</h5>
                <p class="grey-text text-lighten-4">
                    Please call 8787-523-506 for any queries.
                </p>
            </div>

        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Copyright &copy; Runmawi {{ $current_time->year }}
        </div>
    </div>
</footer>
