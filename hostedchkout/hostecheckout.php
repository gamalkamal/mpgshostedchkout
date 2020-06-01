<?php
$merchant = $amount = $description = $phone = $Email = $apipassword = $jsurl = $ssurl = $rwurl = "";

$apipassword = $_POST['apipassword'];
$merchant = $_POST['merchant'];
$jsurl = $_POST['jsurl'];
$ssurl = $_POST['ssurl'];
$rwurl = $_POST['rwurl'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$phone = $_POST['phone'];
$Email = $_POST['Email'];
$order_id = date("YmdHis");
//$order_id = $merchant . '-' . date("YmdHis");
//$order_id = $merchant . '-' . uniqid(rand(), true) . date("YmdHis");
$comurl = "https://mpgstests.herokuapp.com/hostedchkout/complete.html";
//Enter interaction.returnUrl below
$url = $rwurl;
$apiUsername = "merchant.$merchant";

$curl = curl_init();
curl_setopt_array($curl, array(
//Enter gateway URL below
  CURLOPT_URL => $ssurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.operation=PURCHASE",
//uncomment below if you want to use interaction.returnUrl and then comment above
  //CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.returnUrl=$url&interaction.operation=PURCHASE",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));

$response = curl_exec($curl);
$err = curl_error($curl);
//$order_id = uniqid(rand(), true);
curl_close($curl);
?>

<html>
 <link rel="stylesheet" type="text/css" href="paystyle.css">

    <head>
        <script src = "<?php echo $jsurl ?>"
                data-complete="completeCallback"
                data-error="<?php echo $url ?>"
                data-cancel="<?php echo $url ?>"
        	data-beforeRedirect="beforeRedirect"
        	data-afterRedirect="afterRedirect"
                data-timeout="<?php echo $url ?>">
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
	var comurl = "<?php echo $comurl ?>";
	var successIndicator = keyValues["successIndicator"];
	var sessionVersion = keyValues["session.version"];
	var sessionId = keyValues["session.id"];
	var merchantID = keyValues["merchant"];
	var amountID = "<?php echo $amount ?>";
	var descriptionID = "<?php echo $description ?>";
	var orderID = "<?php echo $order_id ?>";
	var emailID = "<?php echo $Email ?>";
	var phoneID = "<?php echo $phone ?>";
	var merchant = "<?php echo $merchant ?>";
	var resultIndicator = null;
       	  function beforeRedirect() {
        	return {
            	successIndicator: successIndicator,
            	orderId: orderID,
            	sessionId: sessionId,
            	sessionVersion:sessionVersion ,
            	merchantId: merchantID,
            	url: url,
            	comurl: comurl
        	};
    	   }
	   function afterRedirect(data) {
		  console.log(data);
		  console.log(resultIndicator);
		  console.log(data.successIndicator);
	        // Compare with the resultIndicator saved in the completeCallback() method
       		 if (resultIndicator) {
        	  var result = (resultIndicator === data.successIndicator) ? "SUCCESS" : "ERROR";
		  //console.log(data.orderId);
     	       	  window.location.href = comurl;
		  //window.location.href = "/mpgstest/hostedchkout/" + data.orderId + "/" + result;
        	}	
        	else {
		  successIndicator = data.successIndicator;
            	  orderId = data.orderId;
                  sessionId = data.sessionId;
                  sessionVersion = data.sessionVersion;
                  merchantId = data.merchantId;
            	  window.location.href = comurl;
		  //window.location.href = "/mpgstest/hostedchkout/" + data.orderId + "/" + data.successIndicator + "/" + data.sessionId;
      	    }}

    	    function completeCallback(response) {
    		  // Save the resultIndicator
        	  resultIndicator = response;
                  var result = (resultIndicator === successIndicator) ? "SUCCESS" : "ERROR";
                 // window.location.href = url;
		  window.location.href = comurl;
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

console.log(orderID);
console.log(sessionId);
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
                        name: merchant,
                        address: {
                            line1: 'Test',
                            line2: 'Test'
       		                 }
                	      },
		    displayControl: {
   		        orderSummary    	: 'HIDE',
            		paymentConfirmation	: 'HIDE',
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
    <p>Merchant Name: <?php echo $merchant ?></p>
    <p>Amount: AUD <?php echo $amount ?></p>
    <p>Phone: <?php echo $phone ?></p>
    <p>Email: <?php echo $Email ?></p>
    <p>Description: <?php echo $description ?></p>
    <h1><input type="button" value="Pay" onclick="Checkout.showLightbox();" /></h1>
    </div>
<!--        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
        <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" /> -->

    </body>
</html>

