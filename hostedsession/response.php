<?php
$merchant = $_POST['merchant'];
$order_id = $merchant . '-' . date("YmdHis");
$apiUsername = "merchant.$merchant";
$amount = $_POST['amount'];
$txnid = uniqid(rand(),true);
$id = $_POST['sessionid'];
$apipassword = $_POST['apipassword'];
$currency = $_POST['currency'];
$curl = curl_init();
curl_setopt_array($curl, array(
//Enter gateway URL below
  CURLOPT_URL => "https://test-gateway.mastercard.com/api/nvp/version/56",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=PAY&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=$currency&order.id=$order_id&order.amount=$amount&session.id=$id&transaction.id=$txnid",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

echo $response;
?>
