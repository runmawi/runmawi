<?php
namespace App\Http\Controllers;

use App\Channel;
use App\PartnerMonetization;
use App\Partnerpayment;
use App\Setting as Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;
use \App\User as User;

class AdminPartnerMonetizationPayouts extends Controller
{

    public function index(Request $request)
    {
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }

        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {
            $users = PartnerMonetization::select('user_id')
                ->with(['channeluser'])
                ->selectSub('SUM(total_views)', 'total_views_sum')
                ->selectSub('SUM(partner_commission)', 'total_commission_sum')
                ->groupBy('user_id')
                ->paginate(9);


            $data = [
                "users" => $users,
                "currencySymbol" => currency_symbol(),
            ];

            return view('admin.partner_monetization_payouts.index', $data);
        }
    }

    public function PartnerAnalytics(Request $request)
    {
        // if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
        //     return redirect('/admin/restrict');
        // }

        $user = User::where("id", 1)->first();
        $duedate = $user->package_ends;
        $current_date = date("Y-m-d");
        if ($current_date > $duedate) {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                "userid" => 0,
            ];

            $headers = [
                "api-key" => "k3Hy5qr73QhXrmHLXhpEh6CQ",
            ];
            $response = $client->request("post", $url, [
                "json" => $params,
                "headers" => $headers,
                "verify" => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                "settings" => $settings,
                "responseBody" => $responseBody,
            ];
            return View::make("admin.expired_dashboard", $data);
        } else {
            $users = PartnerMonetization::orderBy("created_at", "DESC")
                ->paginate(9);
            $data = [
                "users" => $users,
                "currencySymbol" => currency_symbol(),
            ];

            return view('admin.partner_monetization_payouts.analytics', $data);
        }
    }

    public function Partnerpayment($id)
    {

        $partner_monetization = PartnerMonetization::where('user_id', $id);
        $partner_payment = Partnerpayment::where('user_id', $id);

        $partnerpayment = $partner_monetization->first();
        $totalCommission = $partner_monetization->sum('partner_commission');
        $totalAmountPaid = $partner_payment->sum('paid_amount');
        $payment_details = $partner_payment->latest()->first();
        $data = array(
            'partnerpayment' => $partnerpayment,
            'payment_details' => $payment_details,
            'totalCommission' => $totalCommission,
            'totalAmountPaid' => $totalAmountPaid,
            "currencySymbol" => currency_symbol(),
        );

        return view('admin.partner_monetization_payouts.partner_payment', $data);
    }

    public function Store(Request $request)
    {
        $input = $request->all();

        $totalCommission = PartnerMonetization::where('user_id', $input['user_id'])
            ->sum('partner_commission');

        $totalPaid = Partnerpayment::where('user_id', $input['user_id'])
            ->sum('paid_amount');

        $remainingAmount = $totalCommission - $totalPaid;

        if ($input['amount'] > $remainingAmount) {
            return redirect()->back()->withErrors(['amount' => 'Payment exceeds the remaining amount.']);
        }

        $partnerpayment = new Partnerpayment();
        $partnerpayment->user_id = $input['user_id'];
        $partnerpayment->amount = $input['amount'];
        $partnerpayment->payment_date = $input['payment_date'];
        $partnerpayment->notes = $input['notes'];
        $partnerpayment->paid_amount = $input['amount'];
        $partnerpayment->balance_amount = $remainingAmount - $input['amount'];
        $partnerpayment->transaction_id = $input['transaction_id'];
        $partnerpayment->payment_method = $input['payment_method'];
        $partnerpayment->save();

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    public function PartnerPaymentHistory(Request $request)
    {
        $payment_details = Channel::all();
        $data = array(
            'payment_details' => $payment_details,
        );

        return view('admin.partner_monetization_payouts.partner_payment_history', $data);
    }

    public function getChannelData($id)
    {
        $payments = Partnerpayment::where('user_id', $id)->orderByDesc('created_at')->get();
      
        if ($payments->isNotEmpty()) {
            $data = $payments->map(function ($payment) {
                $formattedDate = Carbon::parse($payment->payment_date)->format('d F,Y');
              
                return [
                    'paid_amount' => $payment->paid_amount,
                    'balance_amount' => $payment->balance_amount,
                    'payment_date' => $formattedDate,
                    'transaction_id' => $payment->transaction_id ? $payment->transaction_id : '-',
                    'payment_method' => $payment->payment_type == 0 ? 'Manual Payment' : 'Payment Gateway',
                    'currencySymbol' =>   currency_symbol(),
                ];
            })->toArray();

            return response()->json($data);
        } else {
            return response()->json([]);
        }
    }

    public function getUserDetails($id)
    {
        $user = Channel::find($id);
        if ($user) {

            $paymentDetails = Partnerpayment::where('user_id', $id)->get();

            $totalPaid = $paymentDetails->sum('paid_amount');
            $totalBalance = $paymentDetails->sum('balance_amount');
            $latestPaymentDate = $paymentDetails->max('payment_date');
            $latestBalanceAmount = $paymentDetails->sortByDesc('payment_date')->first()->balance_amount ?? 0;
            $latestPaidAmount = $paymentDetails->sortByDesc('payment_date')->first()->paid_amount ?? 0;

            return response()->json([
                'user_id' => $user->id,
                'total_paid' => $totalPaid,
                'total_balance' => $totalBalance,
                'latest_payment_date' => $latestPaymentDate ? \Carbon\Carbon::parse($latestPaymentDate)->format('d-M-Y') : '-',
                'latest_payment_datetime' => $latestPaymentDate ? \Carbon\Carbon::parse($latestPaymentDate)->format('d-M-Y h:i A') : '-',
                'latest_balance_amount' => $latestBalanceAmount,
                'latest_paid_amount' => $latestPaidAmount,
                "currencySymbol" => currency_symbol(),
            ]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

}
