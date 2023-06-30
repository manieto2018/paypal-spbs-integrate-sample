<?php 
    session_start();
    $rootPath = "";

    include_once('api/Config/Config.php');
    $baseUrl = str_replace("index.php", "", URL['current']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPBS Integration</title>

    <link rel="stylesheet" href="assets/css.css">
</head>
<body>

    <div id="app">
        <h1>Cancun Airport Transportation</h1>

        <div class="is-flex">
            <!-- Choose a service -->
            <div class="item-service item-service-selected" data-service="Private">
                <span class="no-events">Private</span>
                <b class="no-events">Transportation</b>
            </div>
            <div class="item-service" data-service="Luxury">
                <span class="no-events">Luxury</span>
                <b class="no-events">Transportation</b>
            </div>
        </div>

        <div class="is-flex">
            <!-- Choose a option payment -->
            <div class="item-payment item-payment-selected" data-payment="card">
                <span class="no-events">Use a <b class="no-events">Credir/Debit Card</b></span>
            </div>
            <div class="item-payment" data-payment="paypal">
                <span class="no-events">Use an account  <b class="no-events">Paypal</b></span>
            </div>
        </div>

        <strong id="total">39<small>USD</small></strong>

        <button id="bookingButton">BOOK NOW</button>
        
        <div id="paypal-button-container" class="hidden"></div>
        <div id="card-button-container" class="hidden"></div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=AR1v40oW4TOsYZ7540Qel_HFS9UlbB1OdxVF17Fg5C0CHOiVie3GIEoENn3BOpQNhWDDsje0ivQSfzEI&currency=USD"></script>
    <script src="assets/app.js"></script>
    <script>
        paypal.Buttons({
            env: '<?= PAYPAL_ENVIRONMENT ?>',
            style: {
                layout: 'vertical',   // horizontal | vertical
                size:   'responsive',   // medium | large | responsive
                shape:  'rect',         // pill | rect
                color:  'blue',         // gold | blue | silver | black,
                fundingicons: false,    // true | false,
                tagline: false          // true | false,
            },
            fundingSource: paypal.FUNDING.PAYPAL,
            createOrder: function() {
                let formData = new FormData();
                
                formData.append('total_amt', 1);
                formData.append('currency', 'USD');
                formData.append('return_url',  '<?= $baseUrl.URL["redirectUrls"]["returnUrl"]?>' + '?commit=true');
                formData.append('cancel_url', '<?= $baseUrl.URL["redirectUrls"]["cancelUrl"]?>');

                return fetch(
                    '<?= $rootPath.URL['services']['orderCreate']?>',
                    {
                        method: 'POST',
                        body: formData
                    }
                ).then(function(response) {
                    return response.json();
                }).then(function(resJson) {
                    console.log('Order ID: '+ resJson.data.id);
                    return resJson.data.id;
                });
            },
            onApprove: function(data, actions) {
                return fetch(
                    '<?= $rootPath.URL['services']['orderCapture'] ?>',
                    {
                        method: 'GET'
                    }
                ).then(function(res) {
                    return res.json();
                }).then(function(res) {
                    if(res.data)
                    {
                        const transactionStatus = res.data.purchase_units[0].payments.captures[0].status;
                        const paypalFee = res.data.purchase_units[0].payments.captures[0].seller_receivable_breakdown.paypal_fee.value; //obtiene el valor del fee 
                        if(transactionStatus == 'COMPLETED')
                        {
                            // Fetch a backend para los eventos post venta
                            // MARIA:: AQUI NECESITO EL PAYPAL FEE
                            console.log(res)
                            console.log('the PayPal Fee is: '+ paypalFee); //muestra el fee que cobra PayPal en consola
                            console.log('Paypal Fee?')
                            return false;
                            // window.location.href = 'pages/success.php';
                        
                        }
                        else {
                            console.log('Ouch ocurrió algún problema')
                            return false;
                        }
                    }
                    
                    console.log('Ouch ocurrió algún problema')
                    

                });
            }

        }).render('#paypal-button-container');

    </script>

    <script>
        paypal.Buttons({
            env: '<?= PAYPAL_ENVIRONMENT ?>',
            style: {
                layout: 'vertical',   // horizontal | vertical
                size:   'responsive',   // medium | large | responsive
                shape:  'rect',         // pill | rect
                color:  'black',         // gold | blue | silver | black,
                fundingicons: false,    // true | false,
                tagline: false          // true | false,
            },
            fundingSource: paypal.FUNDING.CARD,
            createOrder: function() {
                let formData = new FormData();
                
                formData.append('total_amt', 39);
                formData.append('currency', 'USD');
                formData.append('return_url',  '<?= $baseUrl.URL["redirectUrls"]["returnUrl"]?>' + '?commit=true');
                formData.append('cancel_url', '<?= $baseUrl.URL["redirectUrls"]["cancelUrl"]?>');

                return fetch(
                    '<?= $rootPath.URL['services']['orderCreate']?>',
                    {
                        method: 'POST',
                        body: formData
                    }
                ).then(function(response) {
                    return response.json();
                }).then(function(resJson) {
                    console.log('Order ID: '+ resJson.data.id);
                    return resJson.data.id;
                });
            },
            onApprove: function(data, actions) {
                return fetch(
                    '<?= $rootPath.URL['services']['orderCapture'] ?>',
                    {
                        method: 'GET'
                    }
                ).then(function(res) {
                    return res.json();
                }).then(function(res) {
                    if(res.data)
                    {
                        const transactionStatus = res.data.purchase_units[0].payments.captures[0].status;
                        const paypalFee = res.data.purchase_units[0].payments.captures[0].seller_receivable_breakdown.paypal_fee.value; //obtiene el valor del fee 
                        if(transactionStatus == 'COMPLETED')
                        {
                            // Fetch a backend para los eventos post venta
                            // MARIA:: AQUI NECESITO EL PAYPAL FEE
                            console.log(res)
                            console.log('the PayPal Fee is: '+ paypalFee); //muestra el fee que cobra PayPal en consola
                            console.log('Paypal Fee?')
                            return false;
                            // window.location.href = 'pages/success.php';
                        
                        }
                        else {
                            console.log('Ouch ocurrió algún problema')
                            return false;
                        }
                    }
                    
                    console.log('Ouch ocurrió algún problema')

                });
            }

        }).render('#card-button-container');
    </script>

</body>
</html>
