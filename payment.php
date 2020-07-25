<?php 


/*
* @Author: Satish p.
* @ purpose: Using Checkout and PHP with stripe
* @params:
* STRIPE_API_KEY: String
* STRIPE_PUBLISHABLE_KEY: String
*/


/* ----------------------------------------------------------------------------------------------------------------------------------------
  Configuration
-------------*/

define('STRIPE_API_KEY', 'sk_test_51H8leNBm0cWKkJ8zUYyRdlE5Cb2EqzG9JBhA3E5ENY9HIVd9vZT6rVWf9INDag2e3L50wXfSK58LIQ1BBAc6ozlS007QrwwAu1'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51H8leNBm0cWKkJ8zZ5dHVXaJ16Ng8w1vC38ZjYrZNCAJvQeyQVeN9fmI1dC2blPLJVdSeHRE2hQWdFSha6vMqfbn003wfDeHxT'); 
 // Include Stripe PHP library 
 require_once('vendor/autoload.php');
 require_once('vendor/stripe/stripe-php/init.php'); 
 // Set API key 
 \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
 // Set API key  with variable
 $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);

/* ----------------------------------------------------------------------------------------------------------------------------------------
 Configuration end
-------------*/


     //Using Checkout and PHP 
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['stripeToken']; 
    $email  = $_POST['stripeEmail'];
    $response = [];

    try{
     $customer = \Stripe\Customer::create([
      'email' => $email,
      'name' => "Satish p.",
      'source'  => $token,
      'address' => [
        'line1' => '510 Townsend St',
        'postal_code' => '98140',
        'city' => 'San Francisco',
        'state' => 'CA',
        'country' => 'US',
      ],
     ]);

     $response["customer"] = $customer;


    $charge = \Stripe\Charge::create([
        'customer' => $customer->id,
        'amount'   => 5000,
        'currency' => 'usd',
        "description" => "Test payment from satish testing mode."
    ]); 
   

     echo '<h1>Successfully charged $50.00!</h1>';
     echo "<pre>";

    $response["charge"] = $charge;

    }catch(Exception $e) {
      $response["error"] = $e;
  }
     echo "<pre>";
     print_r($response);
 die;  



 $payment_id = $statusMsg = ''; 
 $ordStatus = 'error'; 

     $name = "test"; 
     //  $email = "profwork.sp18@gmail.com"; 
 
     $itemName = "Demo Product"; 
     $itemNumber = "PN12345"; 
     // $itemPrice = 25; 
     // $currency = "USD"; 
 
     $itemPrice = 2000; 
     $currency = "INR";

    $plan = Stripe\Plan::create(array(
        "product" => [
            "name" => $name,
            "type" => "service"
        ],
        "nickname" => $name,
        "interval" => "month",
        "interval_count" => "1",
        "currency" => $currency,
        "amount" => $itemPrice * 100,
    ));
    $response["plan"] = $plan;
    
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'name' => $name,
        'address' => [
            'line1' => '510 Townsend St',
            'postal_code' => '98140',
            'city' => 'San Francisco',
            'state' => 'CA',
            'country' => 'US',
        ],
    ));

    $response["customer"] = $customer;
 

    $paymentMethods = $stripe->paymentMethods->create([
        'type' => 'card',
        'card' => [
          'number' => '4242424242424242',
          'exp_month' => 7,
          'exp_year' => 2021,
          'cvc' => '314',
        ],
      ]);

      $response["paymentMethods"] = $paymentMethods;


    $intent = \Stripe\PaymentIntent::create([
        'amount' => 1099,
        'currency' => 'usd',
        // Verify your integration in this guide by including this parameter
        'setup_future_usage' => 'off_session',
        'metadata' => ['integration_check' => 'accept_a_payment'],
      ]);

      $response["intent"] = $intent;


      $stripe->paymentMethods->all([
        'customer' => $customer->id,
        'type' => 'card',
      ]);

     
      $stripe->paymentMethods->attach(
        'pm_1H3jJFL615n2KD7apR5HkKnD',
        ['customer' => 'cus_HczHRsXAelnP39']
      );

      $response["paymentMethods"] = $stripe;


/* ----------------------------------------------------------------------------------------------------------------------------------------
  Coupons code
-------------*/
                  Stripe\Stripe::setApiKey($site->stripe_secret);
                   $customer = Stripe\Customer::create([
                       'email' => $request->customer_email,
                       'source' => $request->stripeToken,
                       'name' => $request->payer_name,
                   ]);
                     $booking_amount = $request->booking_amount;
                    if(isset($request->coupon_code) && $request->coupon_code!=null){
                   try{
                       $coupon_code = $request->coupon_code;
                       $coupon = \Stripe\Coupon::retrieve($coupon_code, []);
                       $amount_off = ($coupon->amount_off) / 100;
                       $percentage_off = ($coupon->percent_off);
                       $booking_amount = $booking_amount - ($request->booking_amount * $percentage_off / 100);
                    
                   }catch(Exception $e) {
                       return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                   }
               }
              
                  $charge = Stripe\Charge::create([
                      "amount" => $booking_amount * 100,
                      "currency" => $site->currency_code,
                      "customer" =>$customer->id,
                      "description" => "Test payment from PartyPerfect.com."
                  ]);
/* ----------------------------------------------------------------------------------------------------------------------------------------
  Coupons code end
-------------*/
 

/* ----------------------------------------------------------------------------------------------------------------------------------------
  Coupons code validate or not api code call to ajex it return true if coupon is valid
-------------*/

     function ValidateCouponStripe($coupon_code=null)
    {

        if($coupon_code!=null){
            try{
                $site = getFooterDetails();
                \Stripe\Stripe::setApiKey($site->stripe_secret);
                $coupon = \Stripe\Coupon::retrieve($coupon_code, []);
               if ($coupon->valid) {
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false]);
                }
                
            }catch(Exception $e) {
               // $errArr['error'] = $e->getMessage();
              //  echo json_encode($errArr);

              return response()->json(['success'=>false]);
            }
        }
        
    }
/* ----------------------------------------------------------------------------------------------------------------------------------------
  Coupons code
-------------*/


//  @Author: Satish p. end code

?>

