<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php
$name = $amount = $description = $phone = $Email = $ssurl = $jsurl = $rwurl = $apipassword = "";
?>

<form class="form" action="hostecheckout.php" method="post">
<ul class="form-style">
<li><label>Merchant Name<span class="required">*</span></label><input type="text" name="merchant" value=""></li>
<li><label>API Password<span class="required">*</span></label><input type="text" name="apipassword" value=""></li>
<li><label>Payent Gateway URL for Javascript<span class="required">*</span></label><input type="url" name="jsurl" size="80" value=""></li>
<li><label>Payent Gateway URL for Session<span class="required">*</span></label><input type="url" name="ssurl" size="80" value=""></li>
<li><label>Your website URL for return call back<span class="required">*</span></label><input type="url" name="rwurl" size="80" value=""></li>
<li><label>Amount<span class="required">*</span></label><input type="number" name="amount" value=1></li>
<li><label>Description <span class="required">*</span></label><input type="text" name="description" value="test" ></li>
<li><label>Phone<span class="required">*</span></label><input type="number" name="phone" value=""></li>
<li><label>Email<span class="required">*</span></label><input type="text" name="Email" value=""></li>
<li><input type="submit" value="Checkout"></li>
</ul>
</form>
</body>
</html>
