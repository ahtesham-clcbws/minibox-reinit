<body style="background-color:#f2f2f2;width: 100% !important;height: 100% !important;margin: 0 !important;">
    <script src="/public/js/jquery.min.js" type="text/javascript"></script>
    <script src="/public/js/html2canvas.min.js" type="text/javascript"></script>
    <style>
        body {
            padding-bottom: 50px;
            position: relative;
        }

        #printButtons {
            position: fixed;
            bottom: 1%;
            left: 1%;
        }

        #printButtons .icon {
            display: inline-block;
            height: 35px;
            width: 35px;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
        }

        #printButtons .icon svg {
            height: 100%;
            width: 100%;
        }

        #printButtons .icon.downloadicon {
            background-color: #00A36C;
        }

        #printButtons .icon.printicon {
            background-color: #088F8F;
        }

        .icon {
            transition: all .2s ease-in-out;
        }

        .icon:hover {
            transform: scale(1.1);
        }
    </style>

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
    <script>
        document.getElementById("printicon").addEventListener("click", function() {
            var originalContents = document.body.innerHTML;

            var printContents = document.getElementById("mainTable").innerHTML;
            // var css = 'body{background-color:white !important;}@page { size: landscape; }';

            document.body.innerHTML = printContents;
            // var head = document.head || document.getElementsByTagName('head')[0];
            // var style = document.createElement('style');
            // if (style.styleSheet) {
            //     style.styleSheet.cssText = css;
            // } else {
            //     style.appendChild(document.createTextNode(css));
            // }

            // head.appendChild(style);

            window.print();

            document.body.innerHTML = originalContents;
        });
        document.getElementById("downloadicon").addEventListener("click", function() {
            html2canvas(document.getElementById("mainTable"), {
                allowTaint: true,
                useCORS: true
            }).then(function(canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                document.createElement("div").appendChild(canvas);
                anchorTag.download = "filename.jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
        });
    </script>