<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/
defined('_MEXEC') or die ('Restricted Access');

$client_id = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
$client_secret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';

/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_USERPWD, $client_id.":".$client_secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
//curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json','Content-Length: ' . strlen($data_string),"Authorization: Bearer Access-Token"));

$result = curl_exec($ch);


if(empty($result))die("Error: No response.");
else{
    $json = json_decode($result);
   // print_r($json->access_token);
   //var_dump($result);
}

curl_close($ch); //THIS CODE IS NOW WORKING!
*/

$data = '{
  "intent": "CAPTURE",
  "purchase_units": [
    {
      "amount": {
        "currency_code": "USD",
        "value": "100.00"
      }
    }
  ]
}';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v2/checkout/orders/5O190127TN364715T/authorize");
//curl_setopt($ch, CURLOPT_USERPWD, $client_id.":".$client_secret);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json','Content-Length: ' . strlen($data),"Authorization: Bearer A21AAEUvu0Or2_rnEOybkkXasGCajnwRntHnaPwezLY-yvvaCHC_zqg1fexPClhyIWFjGx9mRcp0F0guDluJoMTkanBFCfNhQ"));

$result = curl_exec($ch);

   var_dump($result);exit;

if(empty($result))die("Error: No response.");
else{
    $json = json_decode($result);
   // print_r($json->access_token);
}

curl_close($ch); //THIS CODE IS NOW WORKING!




//exit;
$total = $this->getVar('amount',10,'post');
?>

<script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
<script>paypal.Buttons().render('#paypal');</script>



<?php
/*
import('core.payment_methods');


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
if (isset($_GET['success']) && $_GET['success'] == 'true') {
$paymentId = $_GET['paymentId'];

//exit;
    $payment = Payment::get($paymentId);
	$execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);
	$transaction = new Transaction();
    $amount = new Amount();
    $details = new Details();

    $details->setShipping(2.2)
        ->setTax(1.3)
        ->setSubtotal(17.50);

    $amount->setCurrency('USD');
    $amount->setTotal(21);
    $amount->setDetails($details);
    $transaction->setAmount($amount);
	$execution->addTransaction($transaction);

    try {
	$result = $payment->execute($execution, $apiContext);
	ResultPrinter::printResult("Executed Payment", "Payment", $payment->getId(), $execution, $result);

        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (Exception $ex) {
	 ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
            exit(1);
        }
    } catch (Exception $ex) {
	ResultPrinter::printError("Executed Payment", "Payment", null, null, $ex);
        exit(1);
    }
	ResultPrinter::printResult("Get Payment", "Payment", $payment->getId(), null, $payment);
    return $payment;
} else {
	 ResultPrinter::printResult("User Cancelled the Approval", null);
    exit;
}
	

/*
$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
		'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
	)
);

		// After Step 2
		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod('paypal');

		$amount = new \PayPal\Api\Amount();
		$amount->setTotal($total);
		$amount->setCurrency('USD');

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount);

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl("http://localhost/tyc/index.php?com=subscriptions&view=subscriptions&task=step_2")->setCancelUrl("http://localhost/tyc/index.php?com=subscriptions&view=subscriptions&task=step_1");

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);
	
		// After Step 3
		try {
		$payment->create($apiContext);
	$apiContext->setConfig(
      array(
        'log.LogEnabled' => true,
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'DEBUG'
      )
);

		echo $payment;
		echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
		}catch (\PayPal\Exception\PayPalConnectionException $ex) {
		// This will print the detailed information on the exception.
		//REALLY HELPFUL FOR DEBUGGING
		echo $ex->getData();
		}


		

//var_dump($this->rows);exit;
*/
?>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="all" />
<div id="paypal"></div>
<div class="table-responsive">
<div class="com-head">
	<h3><?php echo Localize::_('subscriptions'); ?></h3>
</div>

</div>
<script>
</script>