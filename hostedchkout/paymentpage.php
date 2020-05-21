<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
$cd = $name = $amount = $description = $phone = $Email = "";
?>

<form class="form" action="session.php" method="post">
<ul class="form-style">
<li><label>Merchant Name<span class="required">*</span></label><input type="text" name="name" value="TESTVIKAS"></li>
<li><label>Amount<span class="required">*</span></label><input type="number" name="amount" value=1></li>
<li><label>Description <span class="required">*</span></label><input type="text" name="description" value="Sun Glasses"></li>
<li><label>Country code<span class="required">*</span></label><input type="number" name="cd" value=61></li>
<li><label>Phone<span class="required">*</span></label><input type="number" name="phone" value=468372014></li>
<li><label>Email<span class="required">*</span></label><input type="text" name="Email" value="vikas.saini@mastercard.com"></li>
<li><input type="submit" value="Checkout"></li>
</ul>
</form>
</body>
</html>
