<?php

use Illuminate\Database\Seeder;
use App\PaymentSetting;
use Carbon\Carbon;

class PaymentSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentSetting::truncate();

        $PaymentSetting = [
            [  'payment_type' => 'Stripe', 
               'live_mode' => '0',
               'stripe_status' => '1',
               'test_secret_key' => 'sk_test_FIoIgIO9hnpVUiWCVj5ZZ96o005Yf8ncUt',
               'test_publishable_key' => 'pk_test_hklBv33GegQSzdApLK6zWuoC00pEBExjiP',
               'live_secret_key' => 'pk_live_51HSfz8LCDC6DTupicxgwkYesACqSItC9sLeguTE5Vw9iZKFCIkZXJxhXNtegHnci0B3KINLSCYeWKUzbFnby4NtT00iYdraqXT',
               'plan_name' => 'prod_JBBTj8CPTb4bXu',
               'live_publishable_key' => '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',
               'paypal_live_mode' => '0',
               'paypal_status' => null,
               'test_paypal_username' => null,
               'test_paypal_password' => null,
               'test_paypal_signature' => null,
               'live_paypal_username' => null,
               'live_paypal_password' => null,
               'live_paypal_signature' => null,
               'paypal_plan_name' => null,
               'status' => null,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],

            [  
            'payment_type' => 'PayPal', 
            'live_mode' => '0',
            'stripe_status' => null,
            'test_secret_key' => null,
            'test_publishable_key' => null,
            'live_secret_key' => null,
            'plan_name' => null,
            'live_publishable_key' => null,
            'paypal_live_mode' => null,
            'paypal_status' => null,
            'test_paypal_username' => 'sb-n4huu8276690_api1.business.example.com',
            'test_paypal_password' => 'X7NYJK4WXXTVXTRM',
            'test_paypal_signature' => 'Aq3sLUsKND3Rb6fAjsWHqxWwcvyrAaPrryEw9x14r8Ag6l8aZ.S-GL9O',
            'live_paypal_username' => 'sb-n4huu8276690_api1.business.example.com',
            'live_paypal_password' => 'X7NYJK4WXXTVXTRM',
            'live_paypal_signature' => 'Aq3sLUsKND3Rb6fAjsWHqxWwcvyrAaPrryEw9x14r8Ag6l8aZ.S-GL9O',
            'paypal_plan_name' => null,
            'status' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
          ]
        ];
        PaymentSetting::insert($PaymentSetting);
    }
}
