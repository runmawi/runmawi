<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use AmrShawky\LaravelCurrency\Facade\Currency;


class AdminCurrencyConvert extends Controller
{

public function Index(){

    $Currency_Converter = Currency::convert()
    ->from('INR')
    ->to('USD')
    ->amount(150)
    ->get();
    dd(  CurrencyConvert()   );

}

}