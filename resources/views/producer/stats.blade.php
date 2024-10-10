@extends('producer.layout')

@section('producer.section')

    <div class="row center">
        <h4>{{ $stats_sources->title }} <br> 
            @if ( $stats_sources->access == "ppv" )
                <small> 
                    ( Producer's share:  {{  $ppv_purchases_amount['ppv_purchases_total_amount']  > 0 ? number_format(( $ppv_purchases_amount['ppv_purchases_cpp_commission_sum']  / $ppv_purchases_amount['ppv_purchases_total_amount']  ) * 100, 2) . '%' : 'N/A' }} )
                </small>
            @endif
    </div>

    @if ( $stats_sources->access != "ppv" )

        <p class='center'>No data. This item is Not PPV </p>

    @else
        <div class="row">
            <div class="col s12 m6">
                <div class="icon-block">
                    <h5 class="center">PPV stats</h5>

                    <p class="center light">
                        Number of purchased on Pay per View (PPV) contents. <br><br>
                        <canvas id="myppv_purchases_count" width="100%" height="70"></canvas>

                        <table>
                            <thead>
                                <tr>
                                    <th colspan=2>Current statistics</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Purchased today : </td>
                                    <td class="right">{{ $ppv_purchases_count['ppv_purchases_today_count'] }}</td>
                                </tr>
                                <tr>
                                    <td>Purchased this month : </td>
                                    <td class="right">{{ $ppv_purchases_count['ppv_purchases_current_month_count'] }}</td>
                                </tr>
                                <tr>
                                    <td>Purchased this year: </td>
                                    <td class="right">{{ $ppv_purchases_count['ppv_purchases_current_year_count'] }}</td>
                                </tr>
                                <tr>
                                    <td>Total purchased : </td>
                                    <td class="right">{{ $ppv_purchases_count['ppv_purchases_total_count'] }}</td>
                                </tr>
                                <tr>
                                    <td>Free access with promotions : </td>
                                    <td class="right">{{ $ppv_purchases_count['Free_access_with_promotions'] }}</td>
                                </tr>
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
                                <tr>
                                    <td>Purchased today : </td>
                                    <td class="right"> {{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_today_total_amount'], 2) }} </td>
                                </tr>
                                <tr>
                                    <td>Purchased this month : </td>
                                    <td class="right"> {{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_current_month_total_amount'], 2) }} </td>
                                </tr>
                                <tr>
                                    <td>Purchased this year: </td>
                                    <td class="right"> {{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_current_year_total_amount'], 2) }} </td>
                                </tr>
                                <tr>
                                    <td>Total purchased : </td>
                                    <td class="right"> {{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_total_amount'], 2) }} </td>
                                </tr>
                                <tr>
                                    <td>
                                        Producer's share ( {{  $ppv_purchases_amount['ppv_purchases_total_amount']  > 0 ? number_format(( $ppv_purchases_amount['ppv_purchases_cpp_commission_sum']  / $ppv_purchases_amount['ppv_purchases_total_amount']  ) * 100, 2) . '%' : 'N/A' }} ) :
                                     </td>
                                    <td class="right"><b> {{ currency_symbol() ." ". number_format( $ppv_purchases_amount['ppv_purchases_cpp_commission_sum'], 2) }} </b></td>
                                </tr>
                                <tr>
                                    <td>Runmawi's share + transaction fee : </td>
                                    <td class="right">{{ currency_symbol() ." ". number_format( $ppv_purchases_amount['ppv_purchases_admin_commission_sum'] , 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table>
                <thead>
                    <tr>
                        <th colspan=2>Last 3 months</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><?php echo date('F, Y', strtotime('-1 Months')); ?> : </td><td class="right">{{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_last_month_total_amount'], 2) }}</td></tr>
                        <tr><td><?php echo date('F, Y', strtotime('-2 Months')); ?> : </td><td class="right">{{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_last2ndmonth_total_amount'], 2) }}</td></tr>
                        <tr><td><?php echo date('F, Y', strtotime('-3 Months')); ?> : </td><td class="right">{{ currency_symbol() ." ".number_format($ppv_purchases_amount['ppv_purchases_last3rdmonth_total_amount'], 2) }}</td></tr>
                </tbody>
            </table>
        </div>
    @endif

    <?php

        $ppv_purchases_count_labels = [];
        $ppv_purchases_count_data = [];

        $ppv_purchases_amount_data = [];

        for ($i = 14; $i >= 0; $i--) {
            $date = Carbon\Carbon::now()->subDays($i)->toDateString();
            
            $count = App\PpvPurchase::where('moderator_id', $cpp_user_id)->whereDate('created_at', $date)->count();

            $amount = App\PpvPurchase::where('moderator_id', $cpp_user_id)->whereDate('created_at', $date)->sum('total_amount');
            
            $ppv_purchases_count_labels[] = $date;
            $ppv_purchases_count_data[] = $count;
            $ppv_purchases_amount_data[] = $amount;
        }

        $ppv_purchases_count_labels = json_encode($ppv_purchases_count_labels);
        $ppv_purchases_count_data = json_encode($ppv_purchases_count_data);
        $ppv_purchases_amount_data = json_encode($ppv_purchases_amount_data);
    ?>

<script>
    $(document).ready(function() {

        $('.modal').modal();

        var ctx1 = document.getElementById('myppv_purchases_count').getContext('2d');
        var myppv_purchases_count = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: <?php echo $ppv_purchases_count_labels; ?>, // Labels (dates)
                datasets: [{
                    label: 'No of purchased',
                    data: <?php echo $ppv_purchases_count_data; ?>, 

                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: ['rgba(54, 162, 235, 0.5)'],
                    borderWidth: 1,
                    fill: true,
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
                labels: <?php echo $ppv_purchases_count_labels; ?>,
                datasets: [{
                    label: 'Earnings (Rs)',
                    data: <?php echo $ppv_purchases_amount_data; ?>, // Total purchase amounts
                    
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor:['rgba(255, 99, 132, 0.5)'],
                    borderWidth: 1,
                    fill:true,
                    tension: 0.1,
                }]
            },
        });
    });
    
    function LoadModule(id, title, param1) {
        title = "";
        $.ajax({
            timeout: 10000,
            url: 'loadmodule.php',
            data: {
                id: id,
                param1: param1,
            },
            error: function(jqXhr, textStatus, errorMessage) {
                if (textStatus == "error")
                    alert("Internet connection is currently unavailable. Please try again.");
                else if (textStatus == "timeout")
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
@endsection