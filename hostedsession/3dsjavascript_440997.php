<html>

<head>
    <script src="https://test-gateway.mastercard.com/static/threeDS/1.3.0/three-ds.min.js"
        data-error="errorCallback" data-cancel="cancelCallback">
        </script>

    <script type="text/javascript">
        //The output of this call will return 'false', since the API is not configured yet
        console.log(ThreeDS.isConfigured());
        /**
        Configure method with the configuration{} parameter set and demonstrates the state change of the ThreeDS object before and after the configure method is invoked.
        */
        var merchantId = 'TESTMPGSVIKAS';
        var sessionId = 'SESSION0002741464799F2129879E57';
        ThreeDS.configure({
            merchantId: merchantId,
            sessionId: sessionId,
            containerId: "3DSUI",
            callback: function () {
                if (ThreeDS.isConfigured())
                    console.log("Done with configure");
            },
            configuration: {
                userLanguage: "en-AU", //Optional parameter
                wsVersion: 57
            }
        });
ThreeDS.onEvent("BEFORE_INITIATE_AUTHENTICATION", function (data) {
    if (data) {
        console.log("About to initiate authentication...");
    }
});
ThreeDS.onEvent("AFTER_INITIATE_AUTHENTICATION", function (data) {
        console.log("AFTER_INITIATE_AUTHENTICATION...");
});
ThreeDS.onEvent("BEFORE_AUTHENTICATE_PAYER", function (data) {
        console.log("BEFORE_AUTHENTICATE_PAYER...");
});
ThreeDS.onEvent("AFTER_AUTHENTICATE_PAYER", function (data) {
        console.log("AFTER_AUTHENTICATE_PAYER...");
});


        //The output of this call will return 'true', since the API is configured
        console.log(ThreeDS.isConfigured());
        // console.log(ThreeDS);
        //The output of the following code might look like "ThreeDS JS API Version : 1.2.0"
        console.log("ThreeDS JS API Version : " + ThreeDS.version);

        var optionalParams = {
            sourceOfFunds: {
                type: "CARD"
            },
                   };
        // var orderId = 'order-' + getId(12);
        var orderId = '1620201473';
        var transactionId = orderId;
        console.log(orderId);
        console.log(transactionId);
        function getId(length) {
            var text = "";
            var charList = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < length; i++) {
                text += charList.charAt(Math.floor(Math.random() * charList.length));
            }
            return text;
        }

        console.log(orderId);
        console.log(transactionId);
        ThreeDS.initiateAuthentication(orderId, transactionId, function (data) {
            if (data && data.error) {
                var error = data.error;

                //Something bad happened, the error value will match what is returned by the Authentication API
                console.error("error.code : ", error.code);
                console.error("error.msg : ", error.msg);
                console.error("error.result : ", error.result);
                console.error("error.status : ", error.status);
            } else {
                console.log("After Initiate 3DS ", data);

                //data.response will contain information like gatewayRecommendation, authentication version, etc.
                console.log("REST API raw response ", data.restApiResponse);
                console.log("Correlation Id", data.correlationId);
                console.log("Gateway Recommendation", data.gatewayRecommendation);
                console.log("HTML Redirect Code", data.htmlRedirectCode);
                console.log("Authentication Version", data.authenticationVersion);
                switch (data.gatewayRecommendation) {
                    case "PROCEED":
                        var delayInMilliseconds = 10000; //10 second
                        setTimeout(function() {
                                authenticatePayer();//merchant's method

                         }, delayInMilliseconds);


                        break;
                    case "DO_NOT_PROCEED":
                        displayReceipt(data);//merchant's method, you can offer the payer the option to try another payment method.
                        break;
                }
            }
        }, optionalParams);
        function authenticatePayer() {
            var optionalParams = {
                fullScreenRedirect: true,
                billing: {
                    address: {
                        city: "London",
                        country: "GBR"
                    }
                },
            };

            ThreeDS.authenticatePayer(orderId, transactionId, function (data) {
                if (!data.error) {
                    //data.response will contain all the response payload from the AUTHENTICATE_PAYER call.
                    console.log("REST API response ", data.restApiResponse);
                    console.log("HTML redirect code", data.htmlRedirectCode);
                    console.log("data.response", data.response);

                    displayReceipt(data);
                }
            }, optionalParams);
        }

       function displayReceipt(apiResponse) {
console.log("API Response in displayReceipt", apiResponse);
debugger;
            var responseBody = {
                "apiResponse": apiResponse
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '3dsresponse.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    document.documentElement.innerHTML = this.response;
debugger;
                }
            }
            xhr.send(JSON.stringify(responseBody));
        }
    </script>
</head>

<body>
    <div id="3DSUI"></div>
</body>

</html>
