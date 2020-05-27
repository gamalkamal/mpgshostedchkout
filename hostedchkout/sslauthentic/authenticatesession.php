<?php
$merchant = $amount = $description = $phone = $Email = $apipassword = $jsurl = $ssurl = $rwurl = "";

$merchant = $_POST['merchant'];
$jsurl = $_POST['jsurl'];
$ssurl = $_POST['ssurl'];
$rwurl = $_POST['rwurl'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$phone = $_POST['phone'];
$Email = $_POST['Email'];
$order_id = $merchant . '-' . date("YmdHis");
//$order_id = $merchant . '-' . uniqid(rand(), true) . date("YmdHis");
$comurl = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/complete.html";
//Enter interaction.returnUrl below
$url = $rwurl;
$apiUsername = "merchant.$merchant";

$curl = curl_init();
curl_setopt_array($curl, array(
//Enter gateway URL below
  CURLOPT_SSLCERT => "/etc/ssl/certs/test.pem",
  CURLOPT_SSLKEY => "/etc/ssl/private/test.key",
  CURLOPT_SSLCERTPASSWD => $merchant,
  CURLOPT_SSLKEYPASSWD => $merchant,
  CURLOPT_URL => $ssurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&order.currency=AUD&order.id=$order_id&interaction.operation=PURCHASE",
//uncomment below if you want to use interaction.returnUrl and then comment above
  //CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.returnUrl=$url&interaction.operation=PURCHASE",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));

$response = curl_exec($curl);
print($response);
$err = curl_error($curl);
//$order_id = uniqid(rand(), true);
curl_close($curl);
?>
