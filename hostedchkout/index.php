<?php

?>

<html>
    <head>
        <script src="https://test-gateway.mastercard.com/checkout/version/55/checkout.js"
                data-error="errorCallback"
                data-cancel="cancelCallback"
                data-complete="completeCallback"
                data-timeout="timeoutCallback">
        </script>

        <script type="text/javascript">
            function errorCallback(error) {
                  console.log(JSON.stringify(error));
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
            }
            function completeCallback(resultIndicator, sessionVersion) {
                  console.log('Payment complete');
            }

            function timeoutCallback() {
                  console.log('Timeout');
            }
            Checkout.configure({
		 session: { 
            		id: "SESSION0002078716766I74287758L2"
       			},
                merchant: 'TESTVIKAS',
                order: {
                    amount: function() {
                        //Dynamic calculation of amount
                        return 80 + 20;
                    },
                    currency: 'AUD',
                    description: 'Ordered goods',
                   id: 'ABSCD3232'
                },
                interaction: {
                    operation: 'AUTHORIZE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.
                    merchant: {
                        name: 'VIKASVM',
                        address: {
                            line1: '333 Ann St',
                            line2: 'Brisbane'            
                        }    
                    }
                                                                }
            });
        </script>
    </head>
    <body>
        ...
        <input type="button" value="Pay with Lightbox" onclick="Checkout.showLightbox();" />
        <input type="button" value="Pay with Payment Page" onclick="Checkout.showPaymentPage();" />
        ...
    </body>
</html>
