<?php
$merchant = $_POST['merchant'];
$merchant = "TESTMPGSVIKAS";
$apipassword = "69e6c92c8b1b88be2a706c0ed9b407ba";
$order_id = $merchant . '-' . date("YmdHis");
$apiUsername = "merchant.$merchant";
$amount = $_POST['amount'];
$txnid = uniqid(rand(),true);
$id = $_POST['sessionid'];
$apipassword = $_POST['apipassword'];
$currency = $_POST['currency'];
$curl = curl_init();
$dsid= "20200525053754";
//$dsid= date("YmdHis");
$paReq = "eAFVUttOwzAMfUfiH6qK1y6XkTImL2hs2oWxaaLAe0ktWrG2I21h/D1O13HxU44THx8fB24O+c77QFtlZTHyRY/7HhamTLLideQ/Pc6CgX+jz8/gMbWI0whNY1HDGqsqfkUvS6iGu7i8DlVfKl/DdvyA7xo6Tk2UPQnsBKnUmjQuag2xeb9dbrToAliXgBztcqpNmeef+JKbqm1KmtA1EsCO91DEOer1dh49L1fjCFiLwZRNUdsvzfshsBOAxu50Wtf7asgYmjQQPBDhIBDyOhD9sJfHVU26Ypv0sqJmwNx7YL9at41TXdHohyzR6TZi83mzCkuJd7fRbPOy2Ezkg7hXbyNg7gUkcY1acsm5ksrj4VBcDRVpb/MQ506lHj9NvQsyiNPsxwzsXaPxEZCzwP4mgNy3tJ7TdCcEeNiXBRIjOf1zBvarerJwfpuafFVC9i+Vs7KNgfO9vXAsGTknBVctjQPAXCnrlkqOtIunzL8PcX72DWyMuk8=";
$TermUrl = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedsession/3ds.php";
$acurl = "https://mtf.gateway.mastercard.com/acs/MastercardACS/ffb76b28-9e4e-4f3e-a6b9-39fc2a4e0cc9";
curl_setopt_array($curl, array(
//Enter gateway URL below
  CURLOPT_URL => $acurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "TermUrl=$TermUrl&PaReq=$paReq",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

echo $response;
?>
