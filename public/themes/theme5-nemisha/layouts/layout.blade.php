@content()

<style>
    .btn-hover:hover {
        background-color: {{ button_bg_color() . '!important' }};
    }

    /*Button Bg color  */
    .btn-hover {
        background-color: {{ button_bg_color() . '!important' }};
    }

    button.btn.signup {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    button.transpar {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    .btn-hover {
        background-color: {{ button_bg_color() . '!important' }};
    }

    button.btn.btn-primary {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    i.ri-settings-4-line.text-primary {
        color: {{ button_bg_color() . '!important' }};
    }

    i.ri-logout-circle-line.text-primary {
        color: {{ button_bg_color() . '!important' }};
    }

    /* price tag in homepage */
    p.p-tag1 {
        background-color: {{ button_bg_color() . '!important' }};
    }


    /* Home page Admin icon */
    .st0 {
        fill: {{ button_bg_color() . '!important' }};
        stroke: {{ button_bg_color() . '!important' }};
    }

    .st0 {
        stroke-width: 0.75;
        stroke-miterlimit: 10;
        fill: {{ button_bg_color() . '!important' }};
        stroke: {{ button_bg_color() . '!important' }};
    }

    .st1 {
        stroke-width: 0.5;
        stroke-miterlimit: 10;
        fill: {{ button_bg_color() . '!important' }};
        stroke: {{ button_bg_color() . '!important' }};
    }

    .st2 {
        fill: {{ button_bg_color() . '!important' }};
    }

    .st3 {
        stroke: {{ button_bg_color() . '!important' }};
    }

    .st4 {
        stroke: {{ button_bg_color() . '!important' }};
    }

    .st5 {
        fill: {{ button_bg_color() . '!important' }};
    }

    .st6 {
        fill: none;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke: {{ button_bg_color() . '!important' }}
    }
</style>

{{-- Toggle - Dark-Mode & Light-Mode --}}

<input type="checkbox" id="toggle">

<script>
    const toggle = document.getElementById('toggle');
    const body = document.body;

    toggle.addEventListener('input', (e) => {
        const isChecked = e.target.checked;

        if (isChecked) {
            body.classList.add('light-theme');
            location.reload(true);
        } else {
            body.classList.remove('light-theme');
            location.reload(true);
        }
    });
</script>
