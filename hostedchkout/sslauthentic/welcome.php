<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php
$name = $amount = $description = $phone = $Email = $ssurl = $jsurl = $rwurl = $apipassword = "";
?>

<form class="form" action="authenticatesession.php" method="post">
<ul class="form-style">
<li><label>Merchant Name<span class="required">*</span></label><input type="text" name="merchant" value="TESTMPGSVIKAS"></li>
<li><label>Payent Gateway URL for Javascript<span class="required">*</span></label><input type="url" name="jsurl" size="80" value="https://test-gateway.mastercard.com/checkout/version/56/checkout.js"></li>
<li><label>Payent Gateway URL for Session<span class="required">*</span></label><input type="url" name="ssurl" size="80" value="https://test-gateway.mastercard.com/api/nvp/version/56"></li>
<li><label>Your website URL for return call back<span class="required">*</span></label><input type="url" name="rwurl" size="80" value="https://ech-10-168-129-136.mastercard.int/mpgstest/hostedchkout/complete.html"></li>
<li><label>Amount<span class="required">*</span></label><input type="number" name="amount" value=1></li>
<li><label>Description <span class="required">*</span></label><input type="text" name="description" value="test" ></li>
<li><label>Phone<span class="required">*</span></label><input type="number" name="phone" value="0468372014"></li>
<li><label>Email<span class="required">*</span></label><input type="text" name="Email" value="vikas.saini@mastercard.com"></li>
<li><input type="submit" value="Checkout"></li>
</ul>
</form>
</body>
</html>
