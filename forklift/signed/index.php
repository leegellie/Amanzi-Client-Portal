<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <title>Amanzi Client Waiver</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/ie10.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">

    <script type="text/javascript" src="/js/addtohomescreen.min.js"></script>
</head>

<body>
    <div class="site-wrapper">
        <div class="pt-5">
            <div class="container">
				<div class="row mb-5 navbar-fixed-top">
                    <div class="col-2"><img class="w-100" alt="Amanzi Granite" longdesc="http://amanzigranite.com" src="/images/web-logo.png"></div>
					<h2 class="col-10 text-dark">Amanzi Waivers Signed</h2>
				</div>
				<div class="row mt-5">
					<div class="w-100" id="station_data"></div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/ie10.js"></script>
<!--<script type="text/javascript" src="/js/functions.js"></script>-->
<script type="text/javascript" src="/signature/jSignature.min.js"></script>

<script>
$(document).ready(function(){    
    loadStation();
});

function loadStation(){
    $("#station_data").load("station.php");
    setTimeout(loadStation, 6000);
	if ($(".recordSet:nth-child(2)>td").last().text().length) {
		console.log($(".recordSet:nth-child(2)>td").last().text());
	}
}
//$.post("station.php", 
//        { currentNumber: currNumString },
//        function(dat){
//            $(dat).find('link').each( function() {
//                $('#linksTable').append(""+$(this).text()+"");
//            });
//});
</script>

</body>
</html>