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
$txn_id = date("YYmdHis");
$currency = $_POST['currency'];
$order_ref = date("YYmdHis");
//$order_id = $merchant . '-' . date("YmdHis");
//$order_id = $merchant . '-' . uniqid(rand(), true) . date("YmdHis");
$comurl = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/complete.html";
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
 //CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=$currency&order.id=$order_id&order.amount=$amount&interaction.operation=PURCHASE&interaction.returnUrl=$rwurl",
//CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=$currency&order.id=$order_id&order.amount=$amount&interaction.operation=PURCHASE&interaction.returnUrl=$rwurl&interaction.merchant.url=$rwurl&interaction.merchant.name=$merchant",
CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=$currency&order.id=$order_id&order.amount=$amount&interaction.operation=PURCHASE&interaction.merchant.url=$rwurl&interaction.merchant.name=$merchant&interaction.timeout=600",
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
<meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="  crossorigin="anonymous"></script>
        <script src="<?php echo $jsurl ?>"
                data-error="errorCallback"
                data-complete="completeCallback"
                data-cancel="cancelCallback">
        </script>

        <script type="text/javascript">
                //data-complete="completeCallback">
                //data-beforeRedirect="beforeRedirect"
                //data-afterRedirect="afterRedirect"
                //data-error="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/error.html"
                //data-cancel="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/cancel.html">
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
console.log(sessionId);
        var merchantID = keyValues["merchant"];
        var amountID = "<?php echo $amount ?>";
        var descriptionID = "<?php echo $description ?>";
        var orderID = "<?php echo $order_id ?>";
        var orderref = "<?php echo $order_ref ?>";
        var transactionId = "<?php echo $txn_id ?>";
        var emailID = "<?php echo $Email ?>";
        var phoneID = "<?php echo $phone ?>";
        var merchant = "<?php echo $merchant ?>";
        var currency = "<?php echo $currency ?>";
        var resultIndicator = null;
console.log(url);
          function beforeRedirect() {
                console.log(orderID);
                console.log("before redirect");
                return {
                        successIndicator: "successIndicator",
                };
           }
           function afterRedirect(data) {
                  //console.log("after redirect");
                  //console.log(resultIndicator);
                  //console.log(data.successIndicator);
                // Compare with the resultIndicator saved in the completeCallback() method
                  window.location.href = "https://www.google.com";
            }
            function completeCallback(resultIndicator, sessionVersion) {
                         console.log('completeCallback');
                //       alert("Payment Success!!");
                  // Save the resultIndicator
        //        resultIndicator = response;
        //          var result = (resultIndicator === successIndicator) ? "SUCCESS" : "ERROR";
                  //window.location.href = "/mpgstest/hostedchkout/" + orderId + "/" + result;
        //        window.location.href = comurl;
                 // window.location.href = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedsession/3dslib/response.php";
/*
                 var receiptdata = {
                        merchant: "TESTMPGSVIKAS",
                        apipassword: "8b1e70742af706873163399ac5eccbe8",
                        orderid: orderId
                        };

                $.post('receipt.php', receiptdata, function (result, status) {
                        console.log(result);
                        });
*/
            }

            function timeoutCallback() {
                  console.log('Timeout');
            }

            function errorCallback(error) {
                  console.log(JSON.stringify(error));
                  console.log('sessionId');
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
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
                    currency: currency,
                    description: descriptionID,
                    id: orderID,
                    reference: orderref,
                    item:{
                          name: "E99994901TEST",
                          quantity: "1",
                          unitPrice: "0.02",
                        },
                    item:{
                          name: "E99994901TEST1",
                          quantity: "2",
                          unitPrice: "0.03",
                        }
                },
/*                      transaction     : {
                                acquirer : {
                                        id : transactionId
                                }
                        },
*/              customer: {
                        email: emailID,
                        phone: phoneID
                },
                interaction: {
                    operation: 'PURCHASE',
                    country: 'AUS',
        //            operation: 'PURCHASE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.
                    merchant: {
                        name: merchant,
                        address: {
                            line1: 'Test',
                            line2: 'Test'
                                 },
                        url: 'https://ech-10-168-129-136.mastercard.int'
                              },
                    displayControl: {
                        orderSummary            : 'HIDE',
                        paymentConfirmation     : 'HIDE',
                        billingAddress          : 'HIDE',
                        customerEmail           : 'HIDE',
                        shipping                : 'HIDE'
                                   }
                          }
            });
        </script>
    <body>
    <div class=box>
    <h2>Review your details</h2>
    <p>Merchant Name: <?php echo $merchant ?></p>
    <p>Amount: AUD <?php echo $amount ?></p>
    <p>Phone: <?php echo $phone ?></p>
    <p>Email: <?php echo $Email ?></p>
    <p>Description: <?php echo $description ?></p>
<input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
      <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />
    </div>
<!--        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
        <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" /> -->

    </body>
</html>
