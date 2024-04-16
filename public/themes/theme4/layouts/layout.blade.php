<!DOCTYPE html>
<html lang="en">

@partial('header')

@content()

@partial('footer')

@scripts()


<style>
    .text-primary {
        color: {{ button_bg_color() . '!important' }};
    }

    /*Button Bg color  */
    button.btn.btn-hover.ab {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    button.btn-hover:before {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    /* sign up  */
    button.btn.btn-hover.btn-primary.btn-block.signup {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    /* profile page */
    .btn {
        border: #f3ece0 !important;
        background-color: {{ button_bg_color() . '!important' }};
    }

    /* price tag in homepage */
    p.p-tag1 {
        background-color: {{ button_bg_color() . '!important' }};
    }

    .p-tag {
        background-color: {{ button_bg_color() . '!important' }};
    }

    .sta {
        color: {{ button_bg_color() . '!important' }};
    }

    .circle {

        stroke-dasharray: 650;
        stroke-dashoffset: 650;
        -webkit-transition: all 0.5s ease-in-out;
        opacity: 0.3;
        stroke: {{ button_bg_color() . '!important' }};
    }
    .header .navbar ul li.menu-item a:hover{
       
    }
    .main-title a:hover, .main-title a:focus{
        color: {{ button_bg_color() . '!important' }}; 
    }
   header .navbar ul li.menu-item a:hover {
   color: {{ button_bg_color() . '!important' }}; 
      
       font-weight: 500;
   }
    .menu-item:hover{
        border-bottom: 2px solid  {{ button_bg_color() . '!important' }};
    }
    .playbtn:hover .triangle {
        stroke-dashoffset: 0;
        opacity: 1;
        animation: trailorPlay 0.7s ease-in-out;
        stroke: {{ button_bg_color() . '!important' }};
    }

    i.ri-settings-4-line.text-primary {
        color: {{ button_bg_color() . '!important' }};
    }
    .f-link li a:hover{
         color: {{ button_bg_color() . '!important' }};
    }
    i.ri-logout-circle-line.text-primary {
        color: {{ button_bg_color() . '!important' }};
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

    .sta {
        color: {{ button_bg_color() . '!important' }};
    }
</style>

{{-- Toggle - Dark-Mode & Light-Mode --}}

<!-- <script>
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
</script> -->

<input type="checkbox" id="toggle">


<script>
    document.addEventListener('DOMContentLoaded', () => {
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
    });

</script>

</html>
