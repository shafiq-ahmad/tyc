<?php
defined('_MEXEC') or die ('Restricted Access');
require 'PayPal-PHP-SDK' . DS . 'autoload.php'; 
//$mail = new PHPMailer();
class Paypal extends Mobject{
	private $user_name = '';
	private $client_id = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
	private $client_secret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';
	private $apiContext=null;
	
	public function __construct(){
		$this->apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($this->client_id,$this->client_secret));
		$config = array(
// values: 'sandbox' for testing
// 'live' for production
"mode" => "sandbox",
'log.LogEnabled' => true,
'log.FileName' => '../PayPal.log',
'log.LogLevel' => 'FINE'
);
	}
	
	public function pay($data){
		// After Step 2
		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod('paypal');

		$amount = new \PayPal\Api\Amount();
		$amount->setTotal($data['total']);
		$amount->setCurrency('USD');

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount);

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl($data['url'])
		->setCancelUrl($data['cancel_url']);

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent('sale')
		->setPayer($payer)
		->setTransactions(array($transaction))
		->setRedirectUrls($redirectUrls);
		
		// After Step 3
		try {
		$payment->create($this->apiContext);
		$this->apiContext->setConfig(
			array(
				'log.LogEnabled' => true,
				'log.FileName' => 'PayPal.log',
				'log.LogLevel' => 'DEBUG'
			)
		);

		echo $payment;

		echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
		// This will print the detailed information on the exception.
		//REALLY HELPFUL FOR DEBUGGING
		echo $ex->getData();
		}

	}

	
	
	
}

