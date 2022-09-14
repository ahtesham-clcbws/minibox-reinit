<style>
    #razorpay-form {
        display: none;
    }
</style>
<script>
    var paymentFirstLink = window.location.href;
    <?php if (isset($paymentFirstLink) && !empty($paymentFirstLink)) { ?>
        paymentFirstLink = '<?= $paymentFirstLink ?>';
    <?php } ?>
</script>
<?php if ($gateway == 'razorpay') : ?>
    <form name="razorpay-form" id="razorpay-form" action="<?= $callback_url; ?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
        <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="" />
        <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="" />
        <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?= $productDescription; ?>" />
        <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?= site_url(uri_string()); ?>" />
        <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?= site_url(uri_string()); ?>" />
        <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="" />
        <!-- main ammount in paisa -->
        <input type="hidden" name="merchant_total" id="merchant_total" value="" />
        <!-- real amount value -->
        <input type="hidden" name="merchant_amount" id="merchant_amount" value="" />
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            key: "<?= RAZORPAY_KEY_ID ?>",
            amount: "",
            name: "Mini Box Office",
            description: "",
            netbanking: true,
            currency: "INR",
            order_id: "",
            prefill: {
                name: "",
                email: "",
                contact: ""
            },
            notes: {},
            handler: function(transaction) {
                transaction.productType = '<?= $productType ?>';
                transaction.gateway = 'razorpay';
                $.ajax({
                    url: '<?= route_to('paymentSuccess') ?>',
                    type: 'post',
                    data: transaction,
                    success: function(response) {
                        console.log(response);
                        try {
                            data = JSON.parse(response);
                            console.log(data);
                            if (data.success == true) {
                                alert('', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                alert(data.message, 'Error', 'error');
                            }
                        } catch (e) {
                            console.log(e);
                            alert('Unable to parse data', 'Error', 'error');
                        }
                    },
                    error: function(error) {
                        console.log(error)
                        alert('Undefined error, please try after some time.', 'Error', 'error');
                    }
                })
                // document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                // document.getElementById('razorpay-form').submit();
            },
            // "modal": {
            //     "ondismiss": function() {
            //         location.reload()
            //     }
            // }
        };
        var razorpay_pay_btn, instance;

        function razorpaySubmit(order_id, amount, userName, userEmail, userPhone, description) {
            options.order_id = order_id;
            options.amount = parseInt(amount) * 100;
            options.prefill.name = userName;
            options.prefill.email = userEmail;
            options.prefill.contact = userPhone;
            options.description = description;

            // var rzp1 = new Razorpay(options);
            // rzp1.open();
            if (!instance) {
                instance = new Razorpay(options);
            }
            instance.open();
        }
    </script>
<?php endif; ?>

<?php if ($gateway == 'other') : ?>
    <script src="https://www.paypal.com/sdk/js?client-id=test&intent=capture&currency=EUR&vault=false&merchant-id=pp_demo_codesample@paypal.com"></script>
    <div id="otherGatewayButtonsModal" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-margin uk-width-1-1">
                <div id="paypalCheckoutContainer"></div>
            </div>
        </div>
    </div>
    <script>
        var otherGateway = '';
        // var paypalInitiator = false;

        function showOtherGatewayOptions() {
            var paymentOption = '<div class="uk-margin uk-width-1-1"> <div class="uk-form-controls uk-width-1-1 uk-text-right"> <select class="uk-select uk-width-1-1" style="max-width: 250px;" required name="othergateway" id="othergateway"> <option value="" selected>Select Gateway</option> <option value="paypal">Paypal</option> <option value="stripe">Stripe</option> </select> </div> </div>';
            $('#showOtherGatewayOptions').html(paymentOption);

            // $('#othergateway').on('change', function(event) {
            //     var value = $(this).val();
            //     console.log(value);
            //     if (value == 'paypal') {
            //         initPayPal();
            //     } else if (value == 'paypal') {
            //         initiateStripe();
            //     } else {
            //         removePaypalStripe();
            //     }
            // })
        }

        function initPayPal() {
            var orderId = '';
            $('#paypalCheckoutContainer').html('');
            // if (!paypalInitiator) {
            paypal.Buttons({
                fundingSource: 'paypal',

                // Set your environment
                env: '<?= PAYPAL_ENVIRONMENT ?>',

                // Set style of buttons
                style: {
                    layout: 'vertical', // horizontal | vertical
                    size: 'medium', // medium | large | responsive
                    shape: 'rect', // pill | rect
                    color: 'black', // gold | blue | silver | black,
                    fundingicons: false, // true | false,
                },

                // Wait for the PayPal button to be clicked
                createOrder: function() {
                    // console.log(payload);
                    // let formData = payload;
                    // let formData = new FormData();
                    let formData = new FormData($('#submitForm')[0]);

                    console.log(Array.from(formData));
                    formData.append('submitForm', 'true');
                    formData.append('paypalOrderCreate', 'true');

                    return fetch(
                        paymentFirstLink, {
                            method: 'POST',
                            body: formData
                        }
                    ).then(function(response) {
                        console.log(response);
                        return response.json();
                    }).then(function(resJson) {
                        console.log(resJson);
                        console.log('Order ID: ' + resJson.data.id);
                        orderId = resJson.data.id;
                        return resJson.data.id;
                    });
                },

                // Wait for the payment to be authorized by the customer
                onApprove: function(data, actions) {
                    const captureOrderHandler = (details) => {
                        const payerName = details.payer.name.given_name
                        paypalPaymentSave(details);
                        console.log(details)
                        console.log('Transaction completed!');
                    }

                    return actions.order.get().then(captureOrderHandler);
                }

            }).render('#paypalCheckoutContainer');
            // paypalInitiator = true;
            // }
            UIkit.modal('#otherGatewayButtonsModal').show();
        }

        function paypalPaymentSave(data) {
            // console.log('payPalOrderSuccess_data')
            // console.log(data)
            $.ajax({
                type: 'POST',
                url: '<?= route_to('paypal_payment_save') ?>',
                data: data,
                success: function(response) {
                    console.log('paypalPaymentSave_response');
                    console.log(response);
                    try {
                        data = JSON.parse(response);
                        console.log(data.data);
                        if (data.success == true) {
                            alert('', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            alert(data.message, 'Error', 'error');
                        }
                    } catch (e) {
                        console.log(e);
                        alert('Undefined error, please try after some time.', '', 'error');
                    }
                }
            });
        }

        function initiateStripe() {}

        function removePaypalStripe() {
            $('#showOtherGatewayOptions');
        }
        document.onreadystatechange = function() {
            if (document.readyState === 'complete') {
                showOtherGatewayOptions();
            }
        }


        UIkit.util.on('#youtubeModal', 'hide', function(ev, index) {
            youtubeModalIframe.attr('src', '');
        });
    </script>
<?php endif; ?>