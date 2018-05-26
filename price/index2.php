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

    <title>Amanzi Client Pricing</title>

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

	<style>
    .matItem {
        min-height: 120px;
        box-shadow: 2px 2px 6px #000;
        text-shadow: 1px 1px 6px #FFF, 1px 1px 6px #FFF, -1px -1px 6px #FFF;
        color: black;
        font-weight: 900;
        background-color:#CCC;
    }
    .filterBox {
		height: 4rem !important;
		font-size: 1.8rem;
    }
    .restart i {
        font-size: 4rem;
        color: #999;
    }
    </style>

</head>

<body>
    <div class="site-wrapper">
        <div class="pt-5">
            <div class="container">
				<div class="row mb-5">
					
                    <div class="col-6 col-md-2 order-1"><img class="w-100" alt="Amanzi Granite" longdesc="http://amanzigranite.com" src="/images/web-logo.png"></div>
					<h2 class="col-12 col-md-8 text-dark order-3">Amanzi Client Pricing</h2>
					<div class="col-6 col-md-2 restart text-right float-right pull-left order-2 hidden"><i class="fa fa-lg fa-close"></i></div>
                    <section class="container align-middle order-4" id="select-start">
                        <h1 class="head-text">Welcome!</h1>
                        <div class="row">
                            <div class="col-12 col-md-3 card-holder">
                                <div class="card">
                                    <h2 class="start-select" id="retail-select" link="retail">Retail</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 card-holder">
                                <div class="card">
                                    <h2 class="start-select" id="cabinet-select" link="cabinet">Cabinet Company</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 card-holder">
                                <div class="card">
                                    <h2 class="start-select" id="builder-select" link="builder">Builder</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 card-holder">
                                <div class="card">
                                    <h2 class="start-select" id="commercial-select" link="commercial">Commercial</h2>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="container align-middle mt-5 hidden order-5" id="select-mat">
                        <div class="row">
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="second-form" id="marb-select" link="marb">Marble &amp; Granite</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 card-holder">
                                <div class="card">
                                    <h2 class="second-form" id="quartz-select" link="quartz">Quartz</h2>
                                </div>
                            </div>
                        </div>
                    </section>

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

<script>
var uType = 'retail';
$(document).ready(function(){    
	$('.start-select').click(function() {
		$('.restart').show();
		uType = $(this).attr('link');
		$('#select-start').hide();
		$('#select-mat').show();
	})
	$('.second-form').click(function() {
		$('#select-mat').hide();
		if ($(this).attr('link') == 'marb') {
			$("#station_data").load("php/marbgran_pull.php");
		} else {
			$("#station_data").load("php/quartz_pull.php");
		}
	})
	$('.restart').click(function() {
		window.location.href='/';
	})
});


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