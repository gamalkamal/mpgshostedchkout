<html>
<head>
<!-- INCLUDE SESSION.JS JAVASCRIPT LIBRARY -->
<script src="https://test-gateway.mastercard.com/form/version/56/merchant/TESTMPGSVIKAS/session.js"></script>
<!-- APPLY CLICK-JACKING STYLING AND HIDE CONTENTS OF THE PAGE -->
<style id="antiClickjack">body{display:none !important;}</style>
</head>
<body>
<div id="wrapper"></div>

<!-- CREATE THE HTML FOR THE PAYMENT PAGE -->

<div>Please enter your payment details:</div>
<h3>Credit Card</h3>
<div>Card Number: <input type="text" id="card-number" class="input-field" title="card number" aria-label="Enter your card number" value="" tabindex="1" readonly></div>
<div>Expiry Month:<input type="text" id="expiry-month" class="input-field" title="expiry month" aria-label="Two digit expiry month" value="" tabindex="2" readonly></div>
<div>Expiry Year:<input type="text" id="expiry-year" class="input-field" title="expiry year" aria-label="Two digit expiry year" value="" tabindex="3" readonly></div>
<div>Security Code:<input type="text" id="security-code" class="input-field" title="security code" aria-label="Three digit CCV security code" value="" tabindex="4" readonly></div>
<div>Cardholder Name:<input type="text" id="cardholder-name" class="input-field" title="cardholder name" aria-label="Enter name on card" value="" tabindex="5" readonly></div>
<div>MID: <input type="text" id="mid" class="input-field" title="Merchant Number" aria-label="Enter your merchant number" value="TESTMPGSVIKAS" tabindex="6"></div>
<div>Amount: <input type="text" id="amount" class="input-field" title="Amount" aria-label="Enter amount" value="1" tabindex="7"></div>
<div>API Password: <input type="text" id="api" class="input-field" title="API Password" aria-label="Enter api password" value="69e6c92c8b1b88be2a706c0ed9b407ba" tabindex="8" readonly></div>
<div>Currency: <input type="text" id="currency" class="input-field" title="currency" aria-label="Enter your currency" value="AUD" tabindex="9"></div>
<div><button id="payButton" onclick="pay('card');">Pay Now</button></div>

<!-- JAVASCRIPT FRAME-BREAKER CODE TO PROVIDE PROTECTION AGAINST IFRAME CLICK-JACKING -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
            number: "#card-number",
            securityCode: "#security-code",
            expiryMonth: "#expiry-month",
            expiryYear: "#expiry-year",
            nameOnCard: "#cardholder-name"
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
			//console.log(response);
		var payload = {
        		merchant: response.merchant,
        		apipassword: document.getElementById("api").value,
        		amount: document.getElementById("amount").value,
        		currency: document.getElementById("currency").value,
        		sessionid: response.session.id
			};
			//console.log(payload);
		$.post("3dssubmit.php", payload, function (data, status) {
			//console.log(data);
			var pairs = data.split('&');

			var result = {};
			pairs.forEach(function(pair) {
    				pair = pair.split('=');
    				result[pair[0]] = decodeURIComponent(pair[1] || '');
			});	
			var jsondata = JSON.parse(JSON.stringify(result));
			console.log(jsondata);
			var ddata = (jsondata['3DSecure.authenticationRedirect.simple.htmlBodyContent']);
			document.getElementById("wrapper").innerHTML = ddata
			console.log($.parseJSON(ddata));
			//console.log(jsondata['3DSecure']['authenticationRedirect']['simple']['htmlBodyContent']);

			var ppairs = ddata.split('+');
			var rresult = {};
			ppairs.forEach(function(pairr) {
    				pairr = pairr.split('=');
    				rresult[pairr[0]] = decodeURIComponent(pairr[1] || '');
			});	
			var jjsondata = JSON.parse(JSON.stringify(rresult));
			console.log(jjsondata);
		});
                  /*  console.log("Session updated with data: " + response.session.id);
  
                    //check if the security code was provided by the user
                    if (response.sourceOfFunds.provided.card.securityCode) {
                        console.log("Security code was provided.");
                    }
  
                    //check if the user entered a Mastercard credit card
                    if (response.sourceOfFunds.provided.card.scheme == 'MASTERCARD') {
                        console.log("The user entered a Mastercard credit card.")
                    }*/
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
</body>
</html>
