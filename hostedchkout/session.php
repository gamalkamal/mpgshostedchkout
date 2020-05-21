<?php
$name = $amount = $description = $phone = $Email = "";

$name = $_POST['name'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$phone = $_POST['phone'];
$cd = $_POST['cd'];
$Email = $_POST['Email'];
$phone = "+".$cd.' '.$phone;
$order_id  = date("YmdHis");
$testcall = "testcall";

//Enter interaction.returnUrl below
$url = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/complete.html";
$merchant = "TESTMPGSVIKAS";
$apiUsername = "merchant.$merchant";
$apipassword = "69e6c92c8b1b88be2a706c0ed9b407ba";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://test-gateway.mastercard.com/api/nvp/version/55/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.operation=AUTHORIZE",
//uncomment below if you want to use interaction.returnUrl and then comment above
  //CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.returnUrl=$url&interaction.operation=AUTHORIZE",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
?>

<html>
    <head>
	<link rel="stylesheet" type="text/css" href="paystyle.css">

        <script src="https://test-gateway.mastercard.com/checkout/version/55/checkout.js"
                data-complete="completeCallback"
                data-error="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/error.html"
                data-cancel="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/cancel.html"
		data-beforeRedirect="beforeRedirect"
        	data-afterRedirect="afterRedirect"
                data-timeout="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/timeout.html">
        </script>

        <script type="text/javascript">
	var params = "<?php echo $response ?>";
	var elements =  params.split('&');
	var keyValues = {};
	for(var i in elements) {
    		var key = elements[i].split("=");
    			if (key.length > 1) {
     				 keyValues[decodeURIComponent(key[0].replace(/\+/g, " "))] = decodeURIComponent(key[1].replace(/\+/g, " "));
   					 }
	}

	var url = "<?php echo $url ?>";
	var successIndicator = keyValues["successIndicator"];
	var sessionVersion = keyValues["session.version"];
	var sessionId = keyValues["session.id"];
	var merchantID = keyValues["merchant"];
	var amountID = "<?php echo $amount ?>";
	var descriptionID = "<?php echo $description ?>";
	var orderID = "<?php echo $order_id ?>";
	var emailID = "<?php echo $Email ?>";
	var phoneID = "<?php echo $phone ?>";
	var testcall = "<?php echo $testcall ?>";
	var resultIndicator = null;
       	  function beforeRedirect() {
        	return {
            	successIndicator: successIndicator,
            	orderId: orderID,
            	sessionId: sessionId,
            	sessionVersion:sessionVersion ,
            	merchantId: merchantID,
            	url: url
        	};
    	   }
	   function afterRedirect(data) {
	        // Compare with the resultIndicator saved in the completeCallback() method
       		 if (resultIndicator) {
        	  var result = (resultIndicator === data.successIndicator) ? "SUCCESS" : "ERROR";
     	       	  window.location.href = "/mpgstest/hostedchkout/error.html/";
        	}	
        	else {
		  successIndicator = data.successIndicator;
            	  orderId = data.orderId;
                  sessionId = data.sessionId;
                  sessionVersion = data.sessionVersion;
                  merchantId = data.merchantId;
            	  window.location.href = "/mpgstest/hostedchkout/complete.html/";
		console.log('data.successIndicator');
      	    }}
    	    function completeCallback(response) {
    		  // Save the resultIndicator
        	  resultIndicator = response;
                  var result = (resultIndicator === successIndicator) ? "SUCCESS" : "ERROR";
                  window.location.href =  "/mpgstest/hostedchkout/complete.html/";
            }

            function errorCallback(error) {
                  console.log(JSON.stringify(error));
		  console.log('sessionId');
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
            }


            function timeoutCallback() {
                  console.log('Timeout');
            }

            Checkout.configure({
		session: { 
            		id: sessionId
       			},
                merchant: merchantID,
                order: {
                    amount: amountID,
                    currency: 'AUD',
                    description: descriptionID,
                    id: orderID
                },
		customer: {
			email: emailID,
			phone: phoneID
		},
                interaction: {
                    operation: 'PURCHASE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.
                    merchant: {
                        name: 'MPGSVIKAS',
                        address: {
                            line1: '53 Glorious Way',
                            line2: 'Forest Lake'
       		                 }
                	      },
		    displayControl: {
   		        orderSummary    	: 'SHOW',
            		paymentConfirmation	: 'SHOW',
            		billingAddress 		: 'HIDE',
         		customerEmail   	: 'HIDE',
         		shipping        	: 'HIDE'
        			   }
        	          }
            });
        </script>
    </head>
    <body>
    <div class=box>
    <h2>Review your details</h2>
    <p>Name: <?php echo $name ?></p>
    <p>Amount: AUD <?php echo $amount ?></p>
    <p>Phone: <?php echo $phone ?></p>
    <p>Email: <?php echo $Email ?></p>
    <p>Description: <?php echo $description ?></p>
    <h1><input type="button" value="Pay" onclick="Checkout.showLightbox();" /></h1>
    </div>
<!--        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
        <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" /> -->
    <h4><a href="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/paymentpage.php">Enter details again</a>
    </body>
</html>

