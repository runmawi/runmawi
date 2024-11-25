<?php

namespace App\Http\Controllers;

use App\PpvPurchase;
use App\Subscription;
use Illuminate\Http\Request;

class AdminTransactionDetailsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('user')
            ->get()
            ->map(function ($transaction) {
                $transaction->transaction_type = 'Subscription';
                $transaction->unique_id = 'sub_' . $transaction->id;
                return $transaction;
            });

        $payPerView = PpvPurchase::with('user')
            ->get()
            ->map(function ($transaction) {
                $transaction->transaction_type = 'PPV Purchase';
                $transaction->unique_id = 'ppv_' . $transaction->id;
                return $transaction;
            });

        $transactions = $subscriptions->concat($payPerView)->sortByDesc('created_at');

        return view('admin.transaction_details.index', compact('transactions'));
    }

    public function edit($unique_id)
    {
        $model = (strpos($unique_id, 'sub_') === 0) ? Subscription::class : PpvPurchase::class;

        $id = substr($unique_id, 4);

        $transaction = $model::find($id);

        if (!$transaction) {
            return redirect()->route('admin.transaction-details.index')->with('error', 'Transaction not found.');
        }

        $transaction->transaction_type = (strpos($unique_id, 'sub_') === 0) ? 'Subscription' : 'PPV Purchase';
        $transaction->unique_id = $unique_id;

        return view('admin.transaction_details.edit', compact('transaction'));
    }

    public function update(Request $request, $unique_id)
    {

        $transactionType = (strpos($unique_id, 'sub_') !== false) ? 'subscription' :
        (strpos($unique_id, 'ppv_') !== false ? 'ppv' : null);

        if (!$transactionType) {
            return redirect()->route('admin.transaction-details.index')->with('error', 'Transaction type not recognized.');
        }

        $transaction = ($transactionType === 'subscription')
        ? Subscription::find(substr($unique_id, 4))
        : PpvPurchase::find(substr($unique_id, 4));

        if (!$transaction) {
            return redirect()->route('admin.transaction-details.index')->with('error', 'Transaction not found.');
        }

        $transaction->payment_id = $request->payment_id;

        $transaction->save();

        return redirect()->route('admin.transaction-details.index')->with('success', 'Transaction updated successfully.');
    }

    public function show($unique_id)
    {
        $model = (strpos($unique_id, 'sub_') === 0) ? Subscription::class : PpvPurchase::class;

        $id = substr($unique_id, 4);

        $transaction = $model::with('user')->find($id);

        if (!$transaction) {
            return redirect()->route('admin.transaction-details.index')->with('error', 'Transaction not found.');
        }

        $transaction->transaction_type = (strpos($unique_id, 'sub_') === 0) ? 'Subscription' : 'PPV Purchase';
        $transaction->unique_id = $unique_id;

        return view('admin.transaction_details.show', compact('transaction'));
    }

}
