<?php

namespace App\Controllers\api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use PhpParser\Node\Expr\Cast\String_;

// use Response;

// // config
// use App\Controllers\Api\Midtrans\Config;

// // Api Resource
// use App\Controllers\Api\Midtrans\Transaction;

// // plumbing
// use App\Controllers\Api\Midtrans\ApiRequestor;
// use App\Controllers\Api\Midtrans\SnapApiRequestor;
// use App\Controllers\Api\Midtrans\Notification;
// use App\Controllers\Api\Midtrans\CoreApi;
// use App\Controllers\Api\Midtrans\Snap;

// // sanitazion
// use App\Controllers\Api\Midtrans\Sanitizer;

class MidtransController extends BaseController
{


    // use ResponseTrait;

    public function index()
    {
    }
    public function getSnapToken()
    {




        $item_list = array();
        $amount = 0;
        \Midtrans\Config::$serverKey = 'SB-Mid-server-LM0x0zEDxOslWvvo2X7t9WLZ';
        if (!isset(\Midtrans\Config::$serverKey)) {
            return "Please set your payment server key";
        }
        \Midtrans\Config::$isProduction = false;

        \Midtrans\Config::$isSanitized = true;

        // Enable 3D-Secure
        \Midtrans\Config::$is3ds = true;

        // Required

        $item_list[] = [
            'id' => "111",
            'price' => 20000,
            'quantity' => 1,
            'name' => "Majohn"
        ];

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 20000, // no decimal allowed for creditcard
        );


        // Optional
        $item_details = $item_list;

        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Optional, remove this to display all available payment methods
        // $enable_payments = array("bca_klikbca");

        // Fill transaction details
        // $transaction = array(
        //     'enabled_payments' => $enable_payments,
        //     'transaction_details' => $transaction_details,
        //     'customer_details' => $customer_details,
        //     'item_details' => $item_details,
        // );
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            $paymentUrl = \Midtrans\Snap::createTransaction($transaction)->redirect_url;
            // $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            $data = [
                'code' => 1,
                'message' => 'success',
                'token' => $snapToken, 'paymentUrl' => $paymentUrl,
                'order_id' => (string) $transaction_details['order_id']
            ];


            // $data = [
            //     'code' => 1,
            //     'message' => 'success',
            //     'result' => $snapToken
            // ];
            // return $snapToken;


            return $this->response->setJSON($data);
            // return response()->json($snapToken);
            // return ['code' => 1, 'message' => 'success', 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0, 'message' => 'failed'];
        }
    }


    public function getSnapToken2()
    {
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-LM0x0zEDxOslWvvo2X7t9WLZ';
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = false;




        $item_list = array();
        $amount = 0;
        \Midtrans\Config::$serverKey = 'SB-Mid-server-LM0x0zEDxOslWvvo2X7t9WLZ';
        if (!isset(\Midtrans\Config::$serverKey)) {
            return "Please set your payment server key";
        }
        \Midtrans\Config::$isProduction = false;

        \Midtrans\Config::$isSanitized = true;

        // Enable 3D-Secure
        \Midtrans\Config::$is3ds = true;

        // Required

        $item_list[] = [
            'id' => "111",
            'price' => 20000,
            'quantity' => 1,
            'name' => "Majohn"
        ];

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 20000, // no decimal allowed for creditcard
        );


        // Optional
        $item_details = $item_list;

        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Optional, remove this to display all available payment methods
        // $enable_payments = array("bca_klikbca");

        // Fill transaction details
        // $transaction = array(
        //     'enabled_payments' => $enable_payments,
        //     'transaction_details' => $transaction_details,
        //     'customer_details' => $customer_details,
        //     'item_details' => $item_details,
        // );
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            $paymentUrl = \Midtrans\Snap::createTransaction($transaction)->redirect_url;
            // $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            $data = [
                'code' => 1,
                'message' => 'success',
                'result' => $snapToken, 'paymentUrl' => $paymentUrl
            ];


            // $data = [
            //     'code' => 1,
            //     'message' => 'success',
            //     'result' => $snapToken
            // ];
            // return $snapToken;


            return $this->response->setJSON($data);
            // return response()->json($snapToken);
            // return ['code' => 1, 'message' => 'success', 'result' => $snapToken];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0, 'message' => 'failed'];
        }
    }
}
