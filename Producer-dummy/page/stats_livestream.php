<?php 
	if(!isset($param1)){
		echo "Paramter missing.";
		
	}
	//GET share percent from database
	$producer_share = 0;
	//$sql = "select producer_share from runmawi.producers where id='$runmawi_producer_userid'";
	$sql = "select share_percent from producers_map where producer_id=$runmawi_producer_userid and video_id=$param1 and category=3";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) == 0){
		echo "<h5>WARNING</h5>";
		echo "Cannot fetch nformation. The information displayed in this page may be inaccurate or wrong data may be displayed.";
		
	}
	$row = mysqli_fetch_array($res);
	$producer_share = $row[0];
	$producer_share = $producer_share/100;
	
	$runmawi_share = 1 - $producer_share;
	
	//Calculate PPV
	$title = "";
	$type = 1;
	$sql = "select id, title, subscription_required status from livestream where id=$param1 and status>=0";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$title = $row[1];
		if($row[2] == 1)
		$type = 2;
	}
	
	
	if(mysqli_num_rows($res) == 0){
		echo "Requested data not found";
		exit;
	}
	$purchased_count_total = 0;
	$purchased_count_today = 0;
	$purchased_count_thismonth = 0;
	$purchased_count_thisyear = 0;
	
	$purchased_amount_total = 0;
	$purchased_amount_today = 0;
	$purchased_amount_thismonth = 0;
	$purchased_amount_thisyear = 0;
	
	//total
	$sql = "select count(*), sum(amount) from payment_webhook where status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0 and video_id=$param1 and category=3))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_total = $row[0];
		if($purchased_count_total > 0) $purchased_amount_total = $row[1];
	}
	
	//today

	$sql = "select count(*), sum(amount) from payment_webhook where status = 'TXN_SUCCESS' and DATE(created_at)=CURDATE() and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0 and video_id=$param1 and category=3))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_today = $row[0];
		if($purchased_count_today > 0) $purchased_amount_today = $row[1];
	}
	
	//this month
	$sql = "select count(*), sum(amount) from payment_webhook where status = 'TXN_SUCCESS' and MONTH(created_at)=MONTH(CURDATE()) and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0 and video_id=$param1 and category=3))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_thismonth = $row[0];
		if($purchased_count_thismonth > 0)  $purchased_amount_thismonth = $row[1];
	}
	
	//this year
	$sql = "select count(*), sum(amount) from payment_webhook where status = 'TXN_SUCCESS' and YEAR(created_at)=YEAR(CURDATE()) and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0 and video_id=$param1 and category=3))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_thisyear = $row[0];
		if($purchased_count_thisyear > 0)  $purchased_amount_thisyear = $row[1];
	}
	
	//Last seven days
	//today
	$chart1_labels = "['-', '-', '-', '-', '-', '-', '-']";
	$chart1_data = "[0,0,0,0,0,0,0]";
	$chart2_data = "[0,0,0,0,0,0,0]";
	
	$total_rows = 0;
	$row_start = 0;
	$limit = 14; //latest 14 days
	$sql = "select count(*), sum(amount), DATE(created_at) from payment_webhook where status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0  and video_id=$param1 and category=3))  group by DATE(created_at)";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$total_rows = mysqli_num_rows($res);
		if($total_rows > $limit)
			$row_start = $total_rows - $limit;
	}
	
	$sql = "select count(*), sum(amount), DATE(created_at) from payment_webhook where status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1  and payment_status=1 and category=3 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0  and video_id=$param1 and category=3))  group by DATE(created_at) order by DATE(created_at) asc LIMIT $row_start, $limit";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		//today
		$chart1_labels = "";
		$chart1_data = "";
		$chart2_data = "";
		
		$curr_date = date("Y-m-d");
		
		while($row = mysqli_fetch_array($res)){
			$chart1_labels .= "'" . $row[2] . "',";
			$chart1_data .= "'" . $row[0] . "',";
			$chart2_data .= "'" . $row[1] . "',";
		}
		
		$chart1_labels = substr($chart1_labels, 0, strlen($chart1_labels) - 1);
		$chart1_labels = "[" . $chart1_labels . "]";
		
		$chart1_data = substr($chart1_data, 0, strlen($chart1_data) - 1);
		$chart1_data = "[" . $chart1_data . "]";
		
		$chart2_data = substr($chart2_data, 0, strlen($chart2_data) - 1);
		$chart2_data = "[" . $chart2_data . "]";
	}
?>
      <!--   Icon Section   -->
	  <div class="row center">
		<h4><?php echo $title ?><br> <small>(Producer's share: <?php echo $producer_share * 100 ?>%)</small></h4>
	  </div>
	  
	  <div class="row">
        <div class="col s12 m6">
          <div class="icon-block">
			
            <h5 class="center">PPV stats</h5>

			<?php
				if($type == 1){
					echo "<p class='center'>No data. This item is free to watch</p>";
				}
				else{
			?>
            <p class="center light">
				Number of purchased on Pay per View (PPV) contents.
				<br><br>
			<canvas id="myChart1" width="100%" height="70"></canvas>
				<table>
					<thead>
					  <tr>
						  <th colspan=2>Current statistics</th>
					  </tr>
					</thead>
					<tbody>
					<tr><td>Purchased today : </td><td class="right"><?php echo $purchased_count_today ?></td></tr>
					<tr><td>Purchased this month : </td><td class="right"><?php echo $purchased_count_thismonth ?></td></tr>
					<tr><td>Purchased this year: </td><td class="right"><?php echo $purchased_count_thisyear ?></td></tr>
					<tr><td>Total purchased : </td><td class="right"><?php echo $purchased_count_total  ?></td></tr>
					<tr><td>Free access with coupons : </td><td class="right">0</td></tr>
					</tbody>
				</table>
			</p>
				<?php } ?>
			
          </div>
        </div>
		
        <div class="col s12 m6">
          <div class="icon-block">
            <h5 class="center">Earnings</h5>

			<?php
				if($type == 1){
					echo "<p class='center'>No data. This item is free to watch</p>";
				}
				else{
			?>
            <p class="center light">
				Earnings from Pay per View (PPV) contents.
			
				<br><br>
				<canvas id="myChart2" width="100%" height="70"></canvas>
				
				<table>
					<thead>
					  <tr>
						  <th colspan=2>Current statistics</th>
					  </tr>
					</thead>
					<tbody>
					<tr><td>Purchased today : </td><td class="right">Rs. <?php echo number_format($purchased_amount_today, 2) ?></td></tr>
					<tr><td>Purchased this month : </td><td class="right">Rs. <?php echo number_format($purchased_amount_thismonth, 2) ?></td></tr>
					<tr><td>Purchased this year: </td><td class="right">Rs. <?php echo number_format($purchased_amount_thisyear, 2) ?></td></tr>
					<tr><td>Total purchased : </td><td class="right">Rs. <?php echo number_format($purchased_amount_total, 2) ?></td></tr>
					<tr><td>Producer's share (<?php echo $producer_share*100 ?>%) : </td><td class="right"><b>Rs. <?php echo number_format($purchased_amount_total * $producer_share, 2) ?></b></td></tr>
					<tr><td>Runmawi's share + transaction fee : </td><td class="right">Rs. <?php echo number_format($purchased_amount_total * $runmawi_share, 2) ?></td></tr>

					</tbody>
				</table>
			</p>
				<?php } ?>
          </div>
        </div>

      </div>
	  
<script>
$(document).ready(function(){
	
	  var ctx1 = document.getElementById('myChart1').getContext('2d');
	  var myChart1 = new Chart(ctx1, {
		type: 'line',
		data: {
			labels: <?php echo $chart1_labels ?>,
			datasets: [{
				label: 'No of purchased',
				data: <?php echo $chart1_data ?>,
				
				borderColor: 'rgb(54, 162, 235)',
				backgroundColor:['rgba(54, 162, 235, 0.5)'],
				borderWidth: 1,
				fill:true,
				tension: 0.1,
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});

	 var ctx2 = document.getElementById('myChart2').getContext('2d');
	  var myChart2 = new Chart(ctx2, {
		type: 'bar',
		data: {
			labels: <?php echo $chart1_labels ?>,
			datasets: [{
				label: 'Earnings (Rs)',
				data: <?php echo $chart2_data ?>,
				
				borderColor: 'rgb(255, 99, 132)',
				backgroundColor:['rgba(255, 99, 132, 0.5)'],
				borderWidth: 1,
				fill:true,
				tension: 0.1,
			}]
		},
	});

	  var ctx3 = document.getElementById('myChart3').getContext('2d');
	  var myChart3 = new Chart(ctx3, {
		type: 'doughnut',
		data: {
			labels: ['Settled amount (Rs)', 'Pending setlement (Rs)'],
			datasets: [{
				label: 'No of purchased',
				data: [30000, 12350],
				backgroundColor: [
				  'rgb(255, 99, 132)',
				  'rgb(54, 162, 235)'
				],
			}]
		},
	});
});
</script>