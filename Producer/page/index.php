<?php	
	require_once "required/session.php";
	require_once "required/config.php";
	require_once "required/mysqlconnect.php";
	require_once "required/router.php";
	/*
		URL supports page id and upto three parameters. Following are the varaibles for accessing the url parameters
		$pageid - name of the page
		$param1 - Parameter 1
		$param2 - Parameter 2
		$param3 = Parameter 3
	*/
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Runmawi - Producer page</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="assets/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/materialize/js/materialize.js"></script>
  <script src="assets/js/init.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-D7DFV3NKJ9"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-D7DFV3NKJ9');
		</script>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="<?php echo $url_host ?>" class="brand-logo">RUNMAWI PRODUCER'S</a>
	
      <ul class="right hide-on-med-and-down">
	    <li><a ><i class="material-icons right">person</i> <?php echo $runmawi_producer_username ?></a></li>
		<li><a href="?changepassword"><i class="material-icons">key</i> </a></li>
        <li><a href="logout.php"><i class="material-icons">logout</i></a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
	    <li><a><i class="material-icons">person</i> <?php echo $runmawi_producer_username ?></a></li>
		<li><a href="?changepassword"><i class="material-icons">key</i> Change password</a></li>
        <li><a href="logout.php"><i class="material-icons">logout</i> Logout</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
	<?php if($filename != "page/profile.php"){ ?>
      <h3 class="header center">  
		    <!-- Modal Trigger -->
			  <a class="amber waves-effect waves-light btn modal-trigger" href="#modal">Choose item here	&equiv;</a>
      </h3>
	  <?php } ?>
	   <!-- Modal Structure -->
			  <div id="modal" class="modal modal-fixed-footer">
				<div class="modal-content left">
					<div class="collection">
					<a href="<?php echo $url_host_full ?>" class="collection-item">Summary </a>
					</div>
				  <h6>Movies</h6>
				  <p>
					<div class="collection">
					<?php
						$sql = "select id, title, category from videos where category=1 and status=1 and id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and category=1 and status>=0)";
						$res = mysqli_query($con, $sql);
						while($row = mysqli_fetch_array($res)){
							$url = $url_host . "?stats/" .$row[0]; //stats/[video_id]
							echo "<a href='$url' class='collection-item'>$row[1]</a>";
						}
					?>
				  </div>
				  </p>
				  
				  <h6>Tv Shows (Series)</h6>
				  <p>
					<div class="collection">
					<?php
						$sql = "select id, title from tvshows where status=1 and id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and category=2 and status>=0)";
						$res = mysqli_query($con, $sql);
						while($row = mysqli_fetch_array($res)){
							$url = $url_host. "?stats_tvshow/" .$row[0]; //stats/[video_id]
							echo "<a href='$url' class='collection-item'>$row[1]</a>";
						}
					?>
				  </div>
				  </p>
				  
				  <h6>Livestream</h6>
				  <p>
					<div class="collection">
					<?php
						$sql = "select id, title from livestream where status=1 and id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and category=3 and status>=0)";
						$res = mysqli_query($con, $sql);
						while($row = mysqli_fetch_array($res)){
							$url = $url_host . "?stats_livestream/" .$row[0]; //stats/[video_id]
							echo "<a href='$url' class='collection-item'>$row[1]</a>";
						}
					?>
				  </div>
				  </p>
				  
				</div>
				<div class="modal-footer">
				  <a href="#" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
				</div>
			  </div>
	  

    </div>
  </div>


  <div class="container">
    <div class="section" id="div-main"> 
		<?php 
		
			require $filename; 
		?>
    </div>
    <br><br>
  </div>

  <footer class="page-footer red">
    <div class="container">
      <div class="row">
        <div class="col s12 m6">
          <h5 class="white-text">About</h5>
          <p class="grey-text text-lighten-4">This portal is for content creators/providers in Runmawi app.</p>
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
      Copyright &copy; Runmawi 2021 
      </div>
    </div>
  </footer>

  
  <script>
	
	$(document).ready(function(){
    $('.modal').modal();
  });
  
  function LoadModule(id, title, param1){
	//Loading(1);
	title = "";
	$.ajax({
		   timeout: 10000, 
		   url: 'loadmodule.php',
		   data: {
			  id: id,
			  param1:param1,
		   },
		   error: function(jqXhr, textStatus, errorMessage) {
				if(textStatus == "error")
					alert("Internet connection is currently unavailable. Please try again.");
				else if(textStatus == "timeout")
					alert("Cannot reach server due to slow network speed. Please try again.");
				else
					alert("Error. Please try again.");
				//Loading(0);
		   },
		   success: function(data) {
			  $("#main-div").html(data);
			  //Loading(0);
		   },
		   type: 'POST'
		});
}
  </script>
  </body>
</html>

