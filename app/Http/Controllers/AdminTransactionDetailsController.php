<?php

namespace App\Http\Controllers;

class AdminTransactionDetailsController extends Controller
{
    public function index()
    {
        return View('admin.transaction_details.index');
    }
}