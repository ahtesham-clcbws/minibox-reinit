
// orders data

{
    "ack": true,
    "data": {
        "id": "3Y737122EK3229605"
    },
    "all_data": {
        "id": "3Y737122EK3229605",
        "status": "CREATED",
        "links": [
            {
                "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605",
                "rel": "self",
                "method": "GET"
            },
            {
                "href": "https://www.sandbox.paypal.com/checkoutnow?token=3Y737122EK3229605",
                "rel": "approve",
                "method": "GET"
            },
            {
                "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605",
                "rel": "update",
                "method": "PATCH"
            },
            {
                "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605/capture",
                "rel": "capture",
                "method": "POST"
            }
        ]
    }
}

// after payment
{
    "accelerated": false,
    "orderID": "3Y737122EK3229605",
    "payerID": "UKX98HWZ3P284",
    "paymentID": null,
    "billingToken": null,
    "facilitatorAccessToken": "A21AAID_TJSs0oF21ZU5J-CBk1snW-ehnH_jeDPHzOEWCkT-b2E0tpETIsb7PVT8lI2vaoxjqwbmZASTkNGVa1SOvEYLAd1Fg",
    "paymentSource": "paypal"
}
{
    "order": {},
    "payment": null
}

// on success page

{
    "id": "3Y737122EK3229605",
    "intent": "CAPTURE",
    "status": "APPROVED",
    "payment_source": {
        "paypal": {
            "email_address": "ahtesham2000-buyer@gmail.com",
            "account_id": "UKX98HWZ3P284",
            "name": {
                "given_name": "test",
                "surname": "buyer"
            },
            "address": {
                "country_code": "IN"
            }
        }
    },
    "purchase_units": [
        {
            "reference_id": "PU1",
            "amount": {
                "currency_code": "EUR",
                "value": "10.00",
                "breakdown": {
                    "item_total": {
                        "currency_code": "EUR",
                        "value": "10.00"
                    }
                }
            },
            "payee": {
                "email_address": "pp_demo_codesample@paypal.com",
                "merchant_id": "RSSKVENB8CUJ8"
            },
            "description": "Camera Shop",
            "custom_id": "CUST-CameraShop",
            "invoice_id": "INV-CameraShop-18780",
            "items": [
                {
                    "name": "DSLR Camera",
                    "unit_amount": {
                        "currency_code": "EUR",
                        "value": "5.00"
                    },
                    "quantity": "2",
                    "description": "Black Camera - Digital SLR",
                    "sku": "sku01",
                    "category": "PHYSICAL_GOODS"
                }
            ],
            "shipping": {
                "name": {
                    "full_name": "test buyer"
                },
                "address": {
                    "address_line_1": "Flat no. 507 Wing A Raheja Residency",
                    "address_line_2": "Film City Road, Goregaon East",
                    "admin_area_2": "Mumbai",
                    "admin_area_1": "Maharashtra",
                    "postal_code": "400097",
                    "country_code": "IN"
                }
            }
        }
    ],
    "payer": {
        "name": {
            "given_name": "test",
            "surname": "buyer"
        },
        "email_address": "ahtesham2000-buyer@gmail.com",
        "payer_id": "UKX98HWZ3P284",
        "address": {
            "country_code": "IN"
        }
    },
    "create_time": "2022-09-12T08:00:28Z",
    "links": [
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605",
            "rel": "self",
            "method": "GET"
        },
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605",
            "rel": "update",
            "method": "PATCH"
        },
        {
            "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3Y737122EK3229605/capture",
            "rel": "capture",
            "method": "POST"
        }
    ]
}