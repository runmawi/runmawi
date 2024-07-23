<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Recurly\Client as RecurlyClient ;
use App\HomeSetting ;
use Theme;

class RecurlyPaymentController extends Controller
{
  
    protected $HomeSetting;

    public function __construct()
    {
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        $this->api_key = 'myApiKey';
        $this->client = new RecurlyClient($this->api_key);
    }

    public function checkout_page(Request $request)
    {

        $data = array(
            'current_theme'     => $this->HomeSetting->theme_choosen,
        );

        return Theme::view('Recurly.checkout_page', $data);
       
    }

    public function subscription(Type $var = null)
    {
        # code...
    }
}
