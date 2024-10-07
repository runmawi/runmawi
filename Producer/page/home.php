<?php

	
	//Calculate PPV
	$sql = "select id, title, director, producer, description, casting, genre, length, release_year, category, tvshow_id, type, ppv_cost, ppv_validity, status from videos where status>=0";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$title = $row[1];
	$type = $row[11];
	
	$purchased_count_total = 0;
	$purchased_count_today = 0;
	$purchased_count_thismonth = 0;
	$purchased_count_lastmonth =0;
	$purchased_count_thisyear = 0;
	
	$purchased_amount_total = 0;
	$purchased_amount_today = 0;
	$purchased_amount_thismonth = 0;
	$purchased_amount_lastmonth = 0;
	$purchased_amount_thisyear = 0;
	
	//total
	$sql = "select count(*), sum(amount) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_total = $row[0];
		if($purchased_count_total > 0) $purchased_amount_total = $row[1];
	}
	
	//today
	$sql = "select count(*), sum(amount) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and DATE(created_at)=CURDATE() and YEAR(created_at)=YEAR(CURDATE()) and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1  and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_today = $row[0];
		if($purchased_count_today > 0) $purchased_amount_today = $row[1];
	}
	
	//this month
	$sql = "select count(*), sum(amount) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and MONTH(created_at)=MONTH(CURDATE()) and YEAR(created_at)=YEAR(CURDATE()) and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_thismonth = $row[0];
		if($purchased_count_thismonth > 0)  $purchased_amount_thismonth = $row[1];
	}
	
	//previous month
	$sql = "select count(*), sum(amount) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and MONTH(created_at)=MONTH(CURDATE())-1 and YEAR(created_at)=YEAR(CURDATE()) and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_lastmonth = $row[0];
		if($purchased_count_lastmonth > 0)  $purchased_amount_lastmonth = $row[1];
	}
	
	
	//this year
	$sql = "select count(*), sum(amount) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and YEAR(created_at)=YEAR(CURDATE()) and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1 and  video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$purchased_count_thisyear = $row[0];
		if($purchased_count_thisyear > 0)  $purchased_amount_thisyear = $row[1];
	}
	
	$promotions  = 0;
	//free acess with coupons/promotions
	$sql = "select count(*), sum(amount) from payment_webhook where amount=0 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and (category=1 or category=2) and payment_status=1 and video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$row = mysqli_fetch_array($res);
		$promotions = $row[0];
		
	}


	
	//Last seven days
	//today
	$chart1_labels = "['-', '-', '-', '-', '-', '-', '-']";
	$chart1_data = "[0,0,0,0,0,0,0]";
	$chart2_data = "[0,0,0,0,0,0,0]";
	
	$total_rows = 0;
	$row_start = 0;
	$limit = 14; //latest 14 days
	$sql = "select count(*), sum(amount), DATE(created_at) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and payment_status=1 and  video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))  group by DATE(created_at) order by DATE(created_at)";
	$res = mysqli_query($con, $sql);
	if(mysqli_num_rows($res) > 0){
		$total_rows = mysqli_num_rows($res);
		if($total_rows > $limit)
			$row_start = $total_rows - $limit;
	}
		
	$sql = "select count(*), sum(amount), DATE(created_at) from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and payment_status=1 and  video_id in (select video_id from producers_map where producer_id=$runmawi_producer_userid and status>=0))  group by DATE(created_at) order by DATE(created_at) asc LIMIT $row_start, $limit"; 
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
		<h4>SUMMARY</h4>
		(Producer portal hi update a ni a, dik lo lai i hmuh chuan Runmawi lam min hriattir turin kan ngen a che.)
	  </div>
	  
	  <div class="row">
        <div class="col s12 m6">
          <div class="icon-block">
			
            <h5 class="center">PPV stats</h5>

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
					<tr><td>Purchased last month : </td><td class="right"><?php echo $purchased_count_lastmonth ?></td></tr>
					<tr><td>Purchased this year: </td><td class="right"><?php echo $purchased_count_thisyear ?></td></tr>
					<tr><td>Total purchased : </td><td class="right"><?php echo $purchased_count_total ?></td></tr>
					<tr><td>Free access with promotions : </td><td class="right"><?php echo $promotions  ?></td></tr>
					</tbody>
				</table>
			</p>

          </div>
        </div>
		
        <div class="col s12 m6">
          <div class="icon-block">
            <h5 class="center">Earnings</h5>
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
					<tr><td>Purchased last month : </td><td class="right">Rs. <?php echo number_format($purchased_amount_lastmonth, 2) ?></td></tr>
					<tr><td>Purchased this year: </td><td class="right">Rs. <?php echo number_format($purchased_amount_thisyear, 2) ?></td></tr>
					<tr><td>Total purchased : </td><td class="right">Rs. <?php echo number_format($purchased_amount_total, 2) ?></td></tr>
					</tbody>
				</table>
			</p>

          </div>
        </div>

		
      </div>
	  
	
	
	  
	 
	  <div class="mt-5">
	  <h5>SALES SUMMARY</h5>
	  <div  style='width:100%; overflow:auto'>
		
		<table style='min-width:600px'>
		<tr>
			<td class=''>Video id</td>
			<td>Title</td>
			<td class=''>Amount(Rs.)</td>
			<td class=''>GST 18%</td>
			<td class=''>Total</td>
			<td class=''>Producer's share</td>
			<td class=''>Runmawi's share</td>
		</tr>
		<?php
			//
			$total_producer_share = 0;
			$total_amount = 0;
			$total_runmawi_share = 0;
			//In producer_map table, video_id is tvshow id for category=2, and livestream id for category=3
			$sql = "select pm.video_id, pm.share_percent, v.title, pm.category from producers_map as pm, videos as v where pm.video_id=v.id and  pm.producer_id=$runmawi_producer_userid and pm.status>=0 and (pm.category=1 or pm.category=2) order by pm.id desc";
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res) > 0){
				while($row = mysqli_fetch_array($res)){
					$producer_share_percent = $row[1];
					$producer_share = $producer_share_percent/100;
					
					$video_id = $row[0];
					$title = $row[2];
					
					$sql = "select count(*), sum(amount), sum(amount) * " . $producer_share . " from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and payment_status=1 and video_id=$row[0] and (category=1 or category=2))";
					$res1 = mysqli_query($con, $sql);
					//echo $sql;
					$row1 = mysqli_fetch_array($res1);
					$total_amount += $row1[1];
					$gst_amount = $row1[1] * 0.18;
					$after_gst_total = number_format($row1[1]-$gst_amount, 2);
					$p_share_after_gst = ($row1[1]-$gst_amount) * (float)$producer_share;
					$runmawi_share = (100 - $producer_share_percent) / 100;
					$runmawi_share_percentage = 100 - $producer_share_percent;
					$r_share_after_gst = ($row1[1]-$gst_amount) * $runmawi_share;
					$total_producer_share += $p_share_after_gst;
					$total_runmawi_share += $r_share_after_gst;
					if($row[3] == 2){
						$sql = "select title from tvshows where id=$row[0]";
						$res2 = mysqli_query($con, $sql);
						$row2 = mysqli_fetch_array($res2);
						$title = $row2[0];
					}
					else if($row[3] == 3){
						$sql = "select title from livestream where id=$row[0]";
						$res2 = mysqli_query($con, $sql);
						$row2 = mysqli_fetch_array($res2);
						$title = $row2[0];
					}
					echo "<tr><td>$video_id</td><td>$title</td><td class=''> " . number_format($row1[1], 2) . "</td><td>$gst_amount</td><td class=''>$after_gst_total</td><td> <b> $p_share_after_gst ($producer_share_percent%)</b></td><td><b>$r_share_after_gst ($runmawi_share_percentage%)</b></td></tr>";
				}
				$total_producer_share = round($total_producer_share);

			}
			echo "<tr><td></td><td></td><td class='right'></td><td>Producer's share</td><td class='right'><b>Rs. ". number_format($total_producer_share, 2) . "</b></td></tr>";
			echo "<tr><td></td><td></td><td class='right'></td><td>Runmawi's share</td><td class='right'><b>Rs. " . number_format($total_runmawi_share, 2) . "</b></td></tr>";
		?>
		
		</table>
		</div>
	  </div>

	  <br>

	  <div class="mt-5" style="overflow:auto">
		<h5>MONTHLY SUMMARY (After all deductions)</h5>
		<!-- <span style="background-color:tomato; color:white">Disclaimer: This section shows <b>code under implementation</b>. Wrong results may be produced.</span> -->
		<?php
			$sql = "select video_id, share_percent, category from producers_map where producer_id=$runmawi_producer_userid and status>=0 order by id desc";
 					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0){
						
						while($row = mysqli_fetch_array($res)){
							
							
							$sql2 = "select title from videos where id=$row[0]";
							if($row[2] == 2){
								$sql2 = "select title from tvshows where id=$row[0]";
							}
							else if($row[2] == 3){
								$sql2 = "select title from livestream where id=$row[0]";
							}
							
							$res1 = mysqli_query($con, $sql2);
							$row1 = mysqli_fetch_array($res1);
							$title = $row1[0];
							
							$producer_share_percent = $row[1];
							if($producer_share_percent > 0){
								$producer_share = $producer_share_percent/100;
								
								$sql = "select MONTHNAME(created_at), YEAR(created_at), count(*), sum(amount), sum(amount) * " . $producer_share . " from payment_webhook where amount>9 and status = 'TXN_SUCCESS' and order_id in (select order_id from orders where status=1 and payment_status=1 and video_id=$row[0] and category=$row[2]) group by MONTHNAME(created_at), MONTH(created_at), YEAR(created_at) order by YEAR(created_at), MONTH(created_at)"; 
								$res1 = mysqli_query($con, $sql); 
								//echo $sql;

								$total_producer_share = isset($row1[4]) ? $row1[4] : "";
								$total_amount = isset($row1[3]) ? $row1[3] : "";
								echo "<h5>$title ($producer_share_percent%)</h5>";
								echo "<table width=100%>";
								echo "<tr><td>Month/Year</td><td style='text-align:center'>Units sold</td><td style='text-align:right'>Total amount</td><td style='text-align:right'>Producer share</td></tr>";
								while($row1 = mysqli_fetch_array($res1)){
									$total_producer_share = $row1[3] ;
									$total_amount = $row1[3] - ($row1[3] * 0.18);
									$total_producer_share = $total_amount * $producer_share;
									echo "<tr>";
									echo "<td>$row1[0], $row1[1]</td>";
									echo "<td style='text-align:center'>$row1[2] units</td>";
									echo "<td style='text-align:right'>Rs. ".number_format($total_amount, 2)." </td>";
									echo "<td style='text-align:right'>Rs.". number_format($total_producer_share, 2)." </td>";
									echo "</tr>";
								}
								echo "</table>";
							}		
						}
					}
 		?>
		
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
