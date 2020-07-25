
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


  <style>
  .StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
<!-- <form action="payment.php" method="post" id="payment-form">
  <div class="form-row">
    <label for="card-element">
      Credit or debit card
    </label>
    <div id="card-element">
     
    </div>

   
    <div id="card-errors" role="alert"></div>
  </div>

<button type="submit" class="btn btn-primary">
    <span class="default">
        <i class="fas fa-lg fa-credit-card"></i>
        Pay Now
    </span>
</button>
</form> -->

</div>
  </div>
</div>

<form action="payment.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="pk_test_51H8leNBm0cWKkJ8zZ5dHVXaJ16Ng8w1vC38ZjYrZNCAJvQeyQVeN9fmI1dC2blPLJVdSeHRE2hQWdFSha6vMqfbn003wfDeHxT"
          data-description="Access for a year"
          data-amount="5000"
          data-locale="auto"></script>
</form>

<!-- <div class='form-row row'>
                            <div class='col-xs-12 form-group card-new'>
                                <label class='control-label'>Coupon Code</label> 
                                        <input  class='form-control card-new' type=text size="6" id="coupon" name="coupon_code"  size='50'/>
                                      <span id="msg"></span>
                            </div>
                        </div> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"></script>



<script>// Create a Stripe client.
var stripe = Stripe('pk_test_51H8leNBm0cWKkJ8zZ5dHVXaJ16Ng8w1vC38ZjYrZNCAJvQeyQVeN9fmI1dC2blPLJVdSeHRE2hQWdFSha6vMqfbn003wfDeHxT');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

// Coupons code validate or not api code call to ajex it return true if coupon is valid

$('#coupon').change(function(){
    requestData = "coupon_code="+$('#coupon').val();
    var coupon_code = $('#coupon').val();
    $.ajax({
      type: "GET",
      url: "{{route('validate-coupon')}}/"+coupon_code,
      data: requestData,
      success: function(response){
          console.log("coupen-response",response);
        if (response.success==true) {
          $('#msg').html('<div class="alert-success">Valid Code!</div>');
        } else {
          $('#msg').html('<div class="alert-danger">Invalid Code!</div>');
        }
      }
    });
  });
//  Coupons code validate or not api code call to ajex it return true if coupon is valid end


</script>



</body>
</html>