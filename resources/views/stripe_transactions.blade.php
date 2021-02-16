@include('header')

<div class="container">
    <div class="row justify-content-center page-height">	
        	<div class="col-md-10 col-sm-offset-1">
                
			<div class="login-block nomargin">

            <h1 class="my_profile">
                <i class="fa fa-edit"></i> 
                <?php echo __('Stripe Transacton History');?>
            </h1>
                
            
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Invoice Number</th>
                          <th scope="col">Date</th>
                          <th scope="col">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <?php
                            $user = Auth::user();
                            ?>
                            @if($user->role == 'subscriber')
                            <?php $invoices = $user->invoices();?>
                            @foreach($invoices as $key => $invoice )
                              <th scope="row">{{ $invoice->number}}</th>
                              <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                              <td>{{ $invoice->total() }}</td>
                          
                            @endforeach
                            @endif
                        </tr>
                       
                      </tbody>
                    </table>

		   <div class="clear"></div>
                
                </div>
        </div>
    </div>
</div>

@extends('footer')