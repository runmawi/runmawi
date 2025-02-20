<?php

namespace App\Http\Controllers;

use App\User;
use App\PpvPurchase;
use App\Subscription;
use App\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminTransactionDetailsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('user')
            ->orderBy('created_at', 'desc') 
            ->get()
            ->map(function ($transaction) {
                $transaction->transaction_type = 'Subscription';
                $transaction->unique_id = 'sub_' . $transaction->id;
                return $transaction;
            });

        $payPerView = PpvPurchase::with('user')
            ->orderBy('created_at', 'desc') 
            ->get()
            ->map(function ($transaction) {
                $transaction->transaction_type = 'PPV Purchase';
                $transaction->unique_id = 'ppv_' . $transaction->id;
                return $transaction;
            });

        $transactions = $subscriptions->concat($payPerView)->sortByDesc('created_at');

        $perPage = 10; 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $transactions->forPage($currentPage, $perPage);
        $paginatedTransactions = new LengthAwarePaginator(
            $currentItems, 
            $transactions->count(), 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $paymentSettings = [
            'stripe_payment_settings' => PaymentSetting::where('payment_type', 'Stripe')->first(),
            'paypal_payment_settings' => PaymentSetting::where('payment_type', 'PayPal')->first(),
            'Razorpay_payment_setting' => PaymentSetting::where('payment_type', 'Razorpay')->first(),
            'paystack_payment_setting' => PaymentSetting::where('payment_type', 'Paystack')->first(),
            'Cinet_payment_setting' => PaymentSetting::where('payment_type', 'CinetPay')->first(),
            'Paydunya_payment_setting' => PaymentSetting::where('payment_type', 'Paydunya')->first(),
            'recurly_payment_setting' => PaymentSetting::where('payment_type', 'Recurly')->first(),
        ];

        return view('admin.transaction_details.index', compact('paginatedTransactions', 'paymentSettings'));
    }

    public function live_search(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->get("query"))){

            
            $output = "";
            $query = $request->get("query");
    
            // Get data from both Subscription and PpvPurchase models
            $subscriptions = Subscription::with('user')
                ->whereHas('user', function($q) use ($query) {
                    $q->where('mobile', 'LIKE', "%" . $query . "%");
                })
                ->orWhere("payment_id", "LIKE", "%" . $query . "%")
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    $transaction->transaction_type = 'Subscription';
                    $transaction->unique_id = 'sub_' . $transaction->id;
                    return $transaction;
                });
    
            $payPerView = PpvPurchase::with('user')
                ->whereHas('user', function($q) use ($query) {
                    $q->where('mobile', 'LIKE', "%" . $query . "%");
                })
                ->orWhere("payment_id", "LIKE", "%" . $query . "%")
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    $transaction->transaction_type = 'PPV Purchase';
                    $transaction->unique_id = 'ppv_' . $transaction->id;
                    return $transaction;
                });
    
            // Merge both subscriptions and pay-per-view data, then sort by creation date
            $transactions = $subscriptions->concat($payPerView)->sortByDesc('created_at');
    
            // Pagination
            $perPage = 10;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $transactions->forPage($currentPage, $perPage);
            $paginatedTransactions = new LengthAwarePaginator(
                $currentItems,
                $transactions->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
    
            // Generate the output for the table rows
            if (count($paginatedTransactions) > 0) {
                $total_row = $paginatedTransactions->count();
                foreach ($paginatedTransactions as $i => $transaction) {
                    $paymentStatus = $transaction->transaction_type == 'Subscription' ? "Success" : $transaction->status;
                    $statusClass = $transaction->status === 'captured' || $transaction->status === 'succeeded' || $transaction->status === 1 ? "bg-success" : "bg-danger";
                    $amount = $transaction->transaction_type == 'Subscription' ? $transaction->price : $transaction->total_amount;
                    $content = "-";
                    
                    // Handle the content for PPV and Subscription transactions
                    if ($transaction->transaction_type != 'Subscription') {
                        if ($transaction->video) {
                            $content = $transaction->video->title;
                        } elseif ($transaction->series) {
                            $content = $transaction->series->title;
                            $content .= $transaction->SeriesSeason ? " (" . $transaction->SeriesSeason->series_seasons_name . ")" : "";
                        } elseif ($transaction->livestream) {
                            $content = $transaction->livestream->title;
                        }
                    }
    
                    // Add the row to the output
                    $output .= '
                    <tr>
                        <td>' . ($i + 1) . '</td>
                        <td>' . ($transaction->user ? $transaction->user->mobile : '-') . '</td>
                        <td>' . $content . '</td>
                        <td>' . ($transaction->payment_id ?: 'N/A') . '</td>
                        <td class="' . $statusClass . '">' . $paymentStatus . '</td>
                        <td>' . ($amount ?: 'N/A') . '</td>
                        <td>' . $transaction->transaction_type . '</td>
                        <td>' . ($transaction->created_at ? $transaction->created_at->format('M d, Y H:i A') : '-') . '</td>
                        <td>
                            <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="View"
                                href="' . route('admin.transaction-details.show', $transaction->unique_id) . '">
                                <img class="ply" src="' . URL::to('/') . '/assets/img/icon/view.svg">
                            </a>';
    
                    if ($transaction->created_at == $transaction->updated_at) {
                        $output .= '
                            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit"
                                href="' . route('admin.transaction-details.edit', $transaction->unique_id) . '">
                                <img class="ply" src="' . URL::to('/') . '/assets/img/icon/edit.svg">
                            </a>';
                    }
    
                    $output .= '
                        </td>
                    </tr>';
                }
            } else {
                $output = '
                    <tr>
                        <td align="center" colspan="9">No Data Found</td>
                    </tr>';
            }
    
            // Return the output as JSON with paginated data
            $data = [
                "table_data" => $output,
                "total_data" => $total_row,
            ];
            echo json_encode($data);
        }
        }
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

        if ($transactionType === 'ppv') {
            $transaction->status = 'captured';
        }
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
