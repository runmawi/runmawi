@include('header')
<style>
   table {
        background: #fff;
        color: #000;
    }
</style>
 <?php 
    $jsonString = file_get_contents(base_path('assets/country_code.json'));   

    $jsondata = json_decode($jsonString, true); 
?>
<div class="container">
    <div class="row justify-content-center page-height">	
        	<div class="col-md-10 col-sm-offset-1">
                
			<div class="login-block nomargin">

            <h1 class="my_profile">
                <i class="fa fa-edit"></i> 
                <?php echo __('My Referral');?>
            </h1>

		      <div class="clear"></div>
                <?php if ( Auth::user()->role != 'admin') { ?>
                <?php if (Auth::user()->role == 'subscriber'){ ?>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                          </tr>
                        </thead>
                        <tbody>
                    <?php 
                        $i = 1;
                        foreach ($myreferral as $referral) { ?>
                         <tr>
                            <td> <?= $i;?> </td>
                            <td> <?= $referral->name;?> </td>
                            <td><?= $referral->email;?></td>
                            <td><?= $referral->role;?></td>
                          </tr>

                        <?php $i++; } ?>
                          
                        </tbody>
                      </table>
                <?php }  } ?>
                
                </div>
        </div>
    </div>
</div>

@extends('footer')