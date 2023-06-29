<?php 

include_once('Config/Config.php');
include_once('Helpers/PayPalHelper.php');

$paypalHelper = new PayPalHelper;
$randNo= (string)rand(10000,20000);
$momentInvoice = strtotime(date('Y-m-d H:i:s'));


$orderData = '{
    "intent" : "CAPTURE",
    "application_context" : {
        "return_url" : "",
        "cancel_url" : ""
    },
    "purchase_units" : [ 
        {
            "reference_id" : "1NVO1C3_'.$momentInvoice.'",
            "description" : "Private Roundtrip Transfer",
            "invoice_id" : "1NVO1C3_'.$momentInvoice.'",
            "custom_id" : "1NVO1C3",
            "amount" : {
                "currency_code" : "'.$_POST['currency'].'",
                "value" : "'.$_POST['total_amt'].'"
            }
        }
    ]
}';



    // "payment_source" : {
    //     "paypal": {
    //         "email_address" : "email.comprador@gmail.com",
    //         "name" : {
    //             "given_name" : "Alex",
    //             "surname" : "Jimenez"
    //         },
    //         "phone" : {
    //             "phone_number" : {
    //                 "national_number" : "9982235933"
    //             }
    //         },
    //         "experience_context" : {
    //             "shipping_preference" : "NO_SHIPPING",
    //             "user_action" : "PAY_NOW",
    //             "landing_page" : "LOGIN",
    //             "return_url" : "test",
    //             "cancel_url" : "test"                  
    //         }
    //     }
    // }



header('Content-Type: application/json');
echo json_encode($paypalHelper->orderCreate($orderData));