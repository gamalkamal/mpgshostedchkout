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
$dsid = $_POST['dsid'];
$pares = $_POST['pares'];
curl_setopt_array($curl, array(
//Enter gateway URL below
  CURLOPT_URL => "https://test-gateway.mastercard.com/api/nvp/version/56",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=PROCESS_ACS_RESULT&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=$currency&3DSecureId=$dsid&order.amount=$amount&session.id=$id&3DSecure.authenticationRedirect.responseUrl=https://ech-10-168-129-136.mastercard.int/mpgstest/hostedsession/simple.php&3DSecure.paRes=$pares",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

echo $response;
?>
