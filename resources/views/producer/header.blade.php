<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="{{ route('producer.home')}}" class="brand-logo">RUNMAWI PRODUCER'S</a>

        <ul class="right hide-on-med-and-down">
            <li><a><i class="material-icons right">person</i> <?php echo @$runmawi_producer_username; ?></a></li>
            <li><a href="?changepassword"><i class="material-icons">key</i> </a></li>
            <li><a href="logout.php"><i class="material-icons">logout</i></a></li>
        </ul>

        <ul id="nav-mobile" class="sidenav">
            <li><a><i class="material-icons">person</i> <?php echo @$runmawi_producer_username; ?></a></li>
            <li><a href="?changepassword"><i class="material-icons">key</i> Change password</a></li>
            <li><a href="logout.php"><i class="material-icons">logout</i> Logout</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
</nav>