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
$order_id  = date("YmdHis");
$nameOnCard = $_POST['nameOnCard'];
$number = $_POST['number'];
$expiryMonth = $_POST['expiryMonth'];
$expiryYear = $_POST['expiryYear'];
$securityCode = $_POST['securityCode'];

//Enter interaction.returnUrl below
$url = $rwurl;
$apiUsername = "merchant.$merchant";
?>
<html>
 <link rel="stylesheet" type="text/css" href="paystyle.css">
<head>
<!-- INCLUDE SESSION.JS JAVASCRIPT LIBRARY -->
<script src="<?php echo $ssurl ?>"></script>
<!-- APPLY CLICK-JACKING STYLING AND HIDE CONTENTS OF THE PAGE -->
<style id="antiClickjack">body{display:none !important;}</style>

<!-- JAVASCRIPT FRAME-BREAKER CODE TO PROVIDE PROTECTION AGAINST IFRAME CLICK-JACKING -->
<script type="text/javascript">

if (self === top) {
    var antiClickjack = document.getElementById("antiClickjack");
    antiClickjack.parentNode.removeChild(antiClickjack);
} else {
    top.location = self.location;
}


PaymentSession.configure({
    fields: {
        // ATTACH HOSTED FIELDS TO YOUR PAYMENT PAGE FOR A CREDIT CARD
        card: {
            number: "<?php echo $number ?>",
            securityCode: "<?php echo $securityCode ?>",
            expiryMonth: "<?php echo $expiryMonth ?>",
            expiryYear: "<?php echo $expiryYear ?>",
            nameOnCard: "<?php echo $nameOnCard ?>"
        }
    },
    //SPECIFY YOUR MITIGATION OPTION HERE
    frameEmbeddingMitigation: ["javascript"],
    callbacks: {
        initialized: function(response) {
            // HANDLE INITIALIZATION RESPONSE
        },
        formSessionUpdate: function(response) {
            // HANDLE RESPONSE FOR UPDATE SESSION
            if (response.status) {
                if ("ok" == response.status) {
                    console.log("Session updated with data: " + response.session.id);
  
                    //check if the security code was provided by the user
                    if (response.sourceOfFunds.provided.card.securityCode) {
                        console.log("Security code was provided.");
                    }
  
                    //check if the user entered a Mastercard credit card
                    if (response.sourceOfFunds.provided.card.scheme == 'MASTERCARD') {
                        console.log("The user entered a Mastercard credit card.")
                    }
                } else if ("fields_in_error" == response.status)  {
  
                    console.log("Session update failed with field errors.");
                    if (response.errors.cardNumber) {
                        console.log("Card number invalid or missing.");
                    }
                    if (response.errors.expiryYear) {
                        console.log("Expiry year invalid or missing.");
                    }
                    if (response.errors.expiryMonth) {
                        console.log("Expiry month invalid or missing.");
                    }
                    if (response.errors.securityCode) {
                        console.log("Security code invalid.");
                    }
                } else if ("request_timeout" == response.status)  {
                    console.log("Session update failed with request timeout: " + response.errors.message);
                } else if ("system_error" == response.status)  {
                    console.log("Session update failed with system error: " + response.errors.message);
                }
            } else {
                console.log("Session update failed: " + response);
            }
        }
    },
    interaction: {
        displayControl: {
            formatCard: "EMBOSSED",
            invalidFieldCharacters: "REJECT"
        }
    }
 });

function pay() {
    // UPDATE THE SESSION WITH THE INPUT FROM HOSTED FIELDS
    PaymentSession.updateSessionFromForm('card');
}


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
    <h1><input type="button" value="Pay" onclick="pay('card');" /></h1>
    </div>
    </body>

</html>
