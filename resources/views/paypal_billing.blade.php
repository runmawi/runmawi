@include('header')

<div class="container">
    <div class="row justify-content-center">	
        	<div class="col-md-10 col-sm-offset-1">
                
			<div class="login-block nomargin">

            <h1 class="my_profile">
                <i class="fa fa-edit"></i> 
                <?php echo __('Paypal Transacton History');?>
            </h1>
                
                <?php
                $sub_id = Auth::user()->paypal_id;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/subscriptions/'.$sub_id.'/transactions?start_time=2018-01-21T07:50:20.940Z&end_time=2025-12-21T07:50:20.940Z');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = GetAccessToken();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                
                    $json_result = json_decode($result);
                
//                    $i = 0;
//                    foreach ($json_result as $trans_result){
//                         echo "Transaction Status :". $json_result->transactions[0]->status."<br>";
//                        $i++;
//                    }
//                
                
                
                
                //echo "<pre>";print_r($json_result);A21AANCe7CMu3fO_rHyfW7zMhglgzun8YVyJAxLIho1xFFx6SBoHhUGpC5ugCRIppufRWC4t1BRyVgSw5_6AQYLq_G1BV3Aeg
                   // $tresult = json_decode($json_result->transactions);
//                    echo "Transaction Status :". $json_result->transactions[0]->status."<br>";
//                    echo "Transaction ID :".  $json_result->transactions[0]->id."<br>";
//                    echo "Transaction Amount :".  $json_result->transactions[0]->amount_with_breakdown->gross_amount->value."  ".$json_result->transactions[0]->amount_with_breakdown->gross_amount->currency_code;
                    //echo "Transaction Amount :".  $json_result->transactions[0]->amount_with_breakdown->gross_amount->value;

                ?>
                
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">STATUS</th>
                          <th scope="col">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row"><?php echo $json_result->transactions[0]->id;?></th>
                          <td><?php echo $json_result->transactions[0]->status;?></td>
                          <td><?php echo $json_result->transactions[0]->amount_with_breakdown->gross_amount->value." ".$json_result->transactions[0]->amount_with_breakdown->gross_amount->currency_code;?></td>
                        </tr>
                       
                      </tbody>
                    </table>

		   <div class="clear"></div>
                
                </div>
        </div>
    </div>
</div>

@extends('footer')