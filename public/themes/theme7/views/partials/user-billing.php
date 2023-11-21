<h2 class="form-signin-heading"><i class="fa fa-credit-card"></i><?= __('Billing Information') ?> </h2>

<br /><br />
<div class="well">
<p><i class="fa fa-credit-card"></i><?= __('Past Invoices') ?> </p>
	<ul class="invoices">
	<?php foreach($invoices as $invoice): ?>
		<li><span class="date"> <?= gmdate("F j, Y", $invoice->created); ?> </span><span class="amount"><?= $invoice->dollars() ?></span>
		<div class="clear"></div>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

<?php if($user->subscribed() && $user->onGracePeriod()): ?>

	<div class="well">
		<p><?= __('You have cancelled your subscription and your account will be active until') ?> <?= date("F j, Y, g:i a", strtotime($user->subscription_ends_at)); ?></p>
		<p><?= __('Still want to be a subscriber?') ?></p>
		<a href="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?= '/' . $user->username; ?>/resume" class="btn btn-info"><?= __('Click Here to Re-activate your Account') ?></a>
	</div>


<?php elseif ($user->subscribed()): ?>

	<div class="well">
	<p><i class="fa fa-credit-card"></i><?= __('Credit Card') ?>  <?php if($user->last_four): ?>(<?= __('Ending in') ?> <?= $user->last_four; ?>)<?php endif; ?></p>
	<a href="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?= '/' . $user->username; ?>/update_cc" class="btn btn-info"><?= __('Update Your Credit Card') ?></a>
	</div>

	<div class="well">
        <p><i class="fa fa-warning"></i> <?= __('Danger Zone') ?></p>
        <a class="btn btn-danger cancel-account"><?= __('Cancel My Account') ?></a>
            <div class="cancel-account-confirmation">
                <br />
                <p><i class="fa fa-exclamation"></i> <?= __('Warning. Are you sure you want to cancel?') ?></p>
                <a class="btn btn-info cancel-cancel"><?= __('No, keep my account active') ?></a> <a class="btn btn-danger" href="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?= '/' . $user->username; ?>/cancel"><?= __('Yes, Cancel My Account') ?></a>
            </div>
	</div>

	<script>
		$(document).ready(function(){
			$('.cancel-account').click(function(){
				$('.cancel-account-confirmation').slideDown();
			});
			$('.cancel-cancel').click(function(){
				$('.cancel-account-confirmation').slideUp();
			});
		});
	</script>

<?php else: ?>
	
		<div class="well">
			<p><?= __('It looks like your account has been cancelled') ?>.</p>
		</div>


<?php endif; ?>

