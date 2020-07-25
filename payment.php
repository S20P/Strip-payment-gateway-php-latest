<?php 


define('STRIPE_API_KEY', 'sk_test_3B5ebao8gkz3CGnqJxUgDGkf00j4cHVOVr'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_7Yi0b5LaoZymhyA8IBY8k2Im00OtUsprKy'); 

 
$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 
 
// Check whether stripe token is not empty 

     
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['stripeToken']; 
    //  $name = $_POST['name']; 
    //  $email = $_POST['email'];

     $name = "test"; 
     $email = "armorier@jacknini.cf"; 

     $itemName = "Demo Product"; 
    $itemNumber = "PN12345"; 
    // $itemPrice = 25; 
    // $currency = "USD"; 

    $itemPrice = 2000; 
    $currency = "INR"; 

    require_once('vendor/autoload.php');
    // Include Stripe PHP library 
   // require_once 'stripe-php/init.php'; 
     require_once('vendor/stripe/stripe-php/init.php'); 
    // Set API key 
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
     

     $response = [];


     
     $stripe = new \Stripe\StripeClient(
        'sk_test_3B5ebao8gkz3CGnqJxUgDGkf00j4cHVOVr'
      );


     
  

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

      // Coupons code
         //  dd("TRY");
         Stripe\Stripe::setApiKey($site->stripe_secret);
         $customer = Stripe\Customer::create([
             'email' => $request->customer_email,
             'source' => $request->stripeToken,
             'name' => $request->payer_name,
         ]);
         // Use Stripe's library to make requests...

           $booking_amount = $request->booking_amount;

           if(isset($request->coupon_code) && $request->coupon_code!=null){
         try{

            // $stripe = new \Stripe\StripeClient($site->stripe_secret);

             $coupon_code = $request->coupon_code;

             $coupon = \Stripe\Coupon::retrieve($coupon_code, []);
     
             $amount_off = ($coupon->amount_off) / 100;
             $percentage_off = ($coupon->percent_off);
             // $discountType = array();
             // if($amount_off != ""){
             //     $discountType['type'] = "amount";
             //     $discountType['off'] = $amount_off;
             // }else if($percentage_off != ""){
             //     $discountType['type'] = "percentage";
             //     $discountType['off'] = $percentage_off;
             // }

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
      // Coupons code end


   


    echo "<pre>";
    print_r($response);
die;



    // $subscription = Stripe\Subscription::create(array(
    //     "customer" => $customer->id,
    //     "items" => array(
    //         array(
    //             "plan" => $plan->id,
    //         ),
    //     ),
    // ));

    $subscription = Stripe\Subscription::create(array(
        'customer' => 'cus_HcskkbWBwQIvjw',
        'items' => [
          ['price' => 'price_1H2jVH2eZvKYlo2ChEOvuoVt'],
        ],
    ));







    echo "<pre>";
    print_r($subscription);

    $array_response = $subscription->jsonSerialize();
    $json_response = json_encode($array_response,true);


    echo "<pre>";
    print_r($json_response);

  
?>

