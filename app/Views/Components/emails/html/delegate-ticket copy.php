<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Email Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        body {
            /* width: 100%; */
            padding-top: 100px;
        }

        #mainDiv {
            max-width: 900px;
            margin: auto;
        }
    </style>
    <style type="text/css">
        .topnav {
            background-color: #333;
            width: 100%;
            position: fixed;
            display: block;
            height: 48px;
            top: 0;
            left: 0;
            z-index: 2;
        }

        /* .topnav a {
            background-color: #ddd;
            color: black;
            border: none;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            float: left;
        } */

        .topnav button {
            background-color: #04AA6D;
            color: white;
            border: none;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            /* float: right; */
        }
    </style>
    <style type="text/css">
        .ticket {
            display: flex;
            font-family: Roboto;
            margin: 16px;
            border: 1px solid #E0E0E0;
            position: relative;
            max-width: 867px;
            max-height: 341px;
        }

        .ticket:before {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-top-color: transparent;
            border-left-color: transparent;
            position: absolute;
            transform: rotate(-45deg);
            left: -18px;
            top: 50%;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket:after {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-top-color: transparent;
            border-left-color: transparent;
            position: absolute;
            transform: rotate(135deg);
            right: -18px;
            top: 50%;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket--start {
            position: relative;
            border-right: 1px dashed #E0E0E0;
        }

        .ticket--start:before {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-top-color: transparent;
            border-left-color: transparent;
            border-right-color: transparent;
            position: absolute;
            transform: rotate(-45deg);
            left: -18px;
            top: -2px;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket--start:after {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-top-color: transparent;
            border-left-color: transparent;
            border-bottom-color: transparent;
            position: absolute;
            transform: rotate(-45deg);
            left: -18px;
            top: 100%;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket--start>img {
            display: block;
            padding: 24px;
            height: 270px;
            padding-top: 35px;
        }

        .ticket--center {
            padding: 24px;
            flex: 1;
        }

        .ticket--center--row {
            display: flex;
            max-width: 570px;
        }

        .ticket--center--row:first-child {
            /* padding-bottom: 48px; */
        }

        .ticketDetailsRow {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 25px;
            transform: translatey(-50%);
            width: 570px;
        }

        .ticket--center--row:last-child {
            margin: 0;
            position: absolute;
            bottom: 25px;
            left: 25px;
            width: 570px;
        }

        /* .ticket--center--row:not(:last-child) {
            padding-bottom: 48px;
        } */

        .ticket--center--row:first-child span {
            color: #4872b0;
            text-transform: uppercase;
            line-height: 24px;
            font-size: 13px;
            font-weight: 500;
        }

        .ticket--center--row:first-child strong {
            font-size: 20px;
            font-weight: 400;
            /* text-transform: uppercase; */
        }

        .ticket--center--col {
            display: flex;
            flex: 1;
            width: 50%;
            box-sizing: border-box;
            flex-direction: column;
        }

        .ticket--center--col:not(:last-child) {
            padding-right: 16px;
        }

        .ticket--end {
            background-color: rgb(72, 114, 176) !important;
            position: relative;
            width: 120px;
        }

        .ticket--end:before {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            position: absolute;
            transform: rotate(-45deg);
            right: -18px;
            top: -2px;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket--end:after {
            content: "";
            width: 32px;
            height: 32px;
            background-color: #fff;
            border: 1px solid #E0E0E0;
            border-right-color: transparent;
            border-left-color: transparent;
            border-bottom-color: transparent;
            position: absolute;
            transform: rotate(-45deg);
            right: -18px;
            top: 100%;
            margin-top: -16px;
            border-radius: 50%;
        }

        .ticket--info--title {
            text-transform: uppercase;
            color: #757575;
            font-size: 13px;
            line-height: 24px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ticket--info--subtitle {
            font-size: 16px;
            line-height: 24px;
            font-weight: 500;
            color: #4872b0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ticket--info--content {
            margin-top: 5px;
            font-size: 13px;
            line-height: 16px;
            font-weight: 500;
            /* white-space: nowrap; */
            /* overflow: hidden; */
            /* text-overflow: ellipsis; */
        }

        .miniboxLogo {
            width: 100%;
            height: 100%;
        }

        .miniboxLogo img {
            width: 25px;
            max-height: 222px;
            position: absolute;
            top: 50%;
            left: 45%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .totalTickets .span {
            font-size: 45px !important;
            font-weight: bold !important;
        }

        .totalTickets .small {
            font-size: 25px !important;
        }

        @media print {
            * {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            body {
                padding-top: 0 !important;
            }
        }

        .textCenter {
            text-align: center;
        }

        .textRight {
            text-align: right;
        }
    </style>
    <?php if (!$email_view) : ?>
        <style>
            /* Absolute Center Spinner */
            .loading {
                display: none;
                position: fixed;
                z-index: 999;
                height: 2em;
                width: 2em;
                overflow: show;
                margin: auto;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
            }

            /* Transparent Overlay */
            .loading:before {
                content: '';
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

                background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
            }

            /* :not(:required) hides these rules from IE9 and below */
            .loading:not(:required) {
                /* hide "loading..." text */
                font: 0/0 a;
                color: transparent;
                text-shadow: none;
                background-color: transparent;
                border: 0;
            }

            .loading:not(:required):after {
                content: '';
                display: block;
                font-size: 10px;
                width: 1em;
                height: 1em;
                margin-top: -0.5em;
                -webkit-animation: spinner 150ms infinite linear;
                -moz-animation: spinner 150ms infinite linear;
                -ms-animation: spinner 150ms infinite linear;
                -o-animation: spinner 150ms infinite linear;
                animation: spinner 150ms infinite linear;
                border-radius: 0.5em;
                -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
                box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            }

            /* Animation */

            @-webkit-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-moz-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-o-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <!-- only if email preview -->
    <!-- <div class="topnav">
        <button type="button" style="float: left;" onclick="printDiv('mainDiv')">Print This</button>
        <button type="button" style="float: right;" id="downloadicon">Download This Ticket</button>
    </div> -->
    <!-- only if email preview -->
    <div id="mainDiv">
        <?php foreach ($items as $key => $item) : ?>
            <div class="ticket">
                <div class="ticket--start">
                    <img src="https://i.ibb.co/W3cK42J/image-1.png" />
                </div>
                <div class="ticket--center" style="position: relative; height: 290px; width: 619px;">
                    <div class="ticket--center--row">
                        <div class="ticket--center--col">
                            <span>2nd Indian Cine Film Festival 2022</span>
                            <strong>for Movie Name</strong>
                        </div>
                        <div class="ticket--center--col totalTickets textRight">
                            <span>
                                <span class="span">2</span><span class="small"> tickets</span>
                            </span>
                        </div>
                    </div>
                    <div class="ticket--center--row ticketDetailsRow">
                        <div class="ticket--center--col">
                            <span class="ticket--info--title">Ticket Details</span>
                            <!-- <span class="ticket--info--subtitle">Thursday, May 14 2020</span> -->
                            <span class="ticket--info--content">Screening & Networking, Master Class on Film Funding [For
                                emerging filmmakers] Screening & Networking, Master Class on Film Funding [For emerging
                                filmmakers], Screening & Networking, Master Class on Film Funding [For emerging
                                filmmakers]</span>
                        </div>
                    </div>
                    <div class="ticket--center--row">
                        <div class="ticket--center--col">
                            <span class="ticket--info--title">Tickets type</span>
                            <span class="ticket--info--content">DELEGATE REGISTRATION</span>
                        </div>
                        <div class="ticket--center--col textCenter">
                            <span class="ticket--info--title">Receipt #</span>
                            <span class="ticket--info--content">#0123456789</span>
                        </div>
                        <div class="ticket--center--col textRight">
                            <span class="ticket--info--title">Ordered By</span>
                            <span class="ticket--info--content">John DOE</span>
                        </div>
                    </div>
                </div>
                <div class="ticket--end">
                    <div class="miniboxLogo"><img src="http://localhost:8080/public/images/rotated-logo.png" /></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- only if email preview -->
    <div class="loading" id="loading">Loading&#8230;</div>
    <div id="printButtons">
        <div class="icon downloadicon" id="downloadicon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-download" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
            </svg>
        </div>
        <div class="icon printicon" id="printicon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-printer" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
            </svg>
        </div>
    </div>
    <script src="/public/js/jquery.min.js" type="text/javascript"></script>
    <script src="/public/js/html2canvas.min.js" type="text/javascript"></script>
    <script>
        function printDiv(divName) {
            var originalContents = document.body.innerHTML;

            var printContents = document.getElementById(divName).innerHTML;
            var css = 'body{background-color:white !important;}@page { size: landscape; }';

            document.body.innerHTML = printContents;
            var head = document.head || document.getElementsByTagName('head')[0];
            var style = document.createElement('style');
            if (style.styleSheet) {
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

            window.print();

            document.body.innerHTML = originalContents;
        }

        document.getElementById("downloadicon").addEventListener("click", function() {
            loaderStart();
            $('#downloadicon').attr('disabled', 'disabled');
            html2canvas(document.getElementById("mainDiv"), {
                allowTaint: true,
                useCORS: true
            }).then(function(canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                document.createElement("div").appendChild(canvas);
                var fileName = Date.now();
                anchorTag.download = fileName + ".jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
                setTimeout(() => {
                    loaderStop();
                    $('#downloadicon').removeAttr('disabled');
                }, 700);
            }).catch((function(error) {
                console.error(error);
                loaderStop();
                $('#downloadicon').removeAttr('disabled');
            }))
        });

        function loaderStart() {
            // $('body').addClass('loading');
            $('#loading').show();
        }

        function loaderStop() {
            // if ($('body').hasClass('loading')) {
            //     $('body').removeClass('loading');
            // }
            $('#loading').hide();
        }
    </script>
    <!-- only if email preview -->
</body>

</html>