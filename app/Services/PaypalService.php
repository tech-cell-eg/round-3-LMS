<?php
namespace App\Services;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Traits\ApiResponse;

class PaypalService{
  use ApiResponse;

  protected $provider;
  public function __construct(){
$this->provider=new PayPalClient;
$this->provider->setApiCredentials(config('paypal'));
$this->provider->getAccessToken();
  }
  public function createOrder($amount,$currency='USD'){
    $order=$this->provider->createOrder([
      'intent'=>'CAPTURE',
      'application_context'=>[
        'return_url'=>route('paypal.success'),
        'cancel_url'=>route('paypal.cancel'),
        'user_action'=>'PAY_NOW',
      
      ],
      'purchase_units'=>[
        [
          'amount'=>[
            'currency_code'=>$currency,
            'value'=> number_format($amount, 2, '.', ''),
                  ]
        ]
      ]
    ]);
    return $order;


  }
  public function captureOrder($token)
  {
      try {
          $response = $this->provider->capturePaymentOrder($token);
          return $response;
      } catch (\Exception $e) {
          return $this->errorResponse(
              'An error occurred while capturing the order',
              500
          );
      }

}}