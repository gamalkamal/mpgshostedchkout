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


$url = "https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/complete.html";
$merchant = "TESTVIKAS";
$apiUsername = "merchant.$merchant";
$apipassword = "f542f182bcc0bc500b8ad03a11d55f3f";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://test-gateway.mastercard.com/api/nvp/version/55/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "apiOperation=CREATE_CHECKOUT_SESSION&merchant=$merchant&apiUsername=$apiUsername&apiPassword=$apipassword&order.currency=AUD&order.id=$order_id&order.amount=$amount&interaction.returnUrl=$url&interaction.operation=AUTHORIZE",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
    "cache-control: no-cache")
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
print $response;

?>


<script type="text/javascript">
var params = "<?php echo $response ?>";
var elements =  params.split('&');
//params.forEach(function(d) {
  //  data.push({key: pair[0], value: pair[1]});

//});
var keyValues = {};
for(var i in elements) { 
    var key = elements[i].split("=");
    if (key.length > 1) {
      keyValues[decodeURIComponent(key[0].replace(/\+/g, " "))] = decodeURIComponent(key[1].replace(/\+/g, " "));
    }
}
console.log(keyValues["merchant"]);
</script>
