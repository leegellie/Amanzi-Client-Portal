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

    <title>Amanzi Material Calculator</title>

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

</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
				<div class="inner cover">

<?PHP
$brand = '';
require_once('db_connect.php');
require_once('classes.php');

//Get Select Brand Dropdown
$brandQ = $conn->query("SELECT DISTINCT brand FROM category ORDER BY brand ASC");
$brandQ->setFetchMode(PDO::FETCH_CLASS, 'selectBrand');

echo '<select id="brandSelector"><option value="">Select Brand</option>', print_r($brandQ->fetchAll()), '</select>';

?>
<input class="form-control" id="myInput" type="text" placeholder="Search..">
<div id="results"></div>

                </div>
            </div>
        </div>
    </div>

<div aria-hidden="true" aria-labelledby="modalLabe4" class="modal fade" id="thank-you" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabe3">Submitted!</h5><button aria-label="Close" class="close" data-dismiss="modal" type="button"><i class="fa fa-lg fa-close"></i></button>
            </div>
            <div class="modal-body">
                <p>Thank you.  Your data has been submitted and an Amanzi representitive will be in touch soon.</p>
            </div>
            <div class="modal-footer">
                <button aria-label="Close" class="btn btn-primary" data-dismiss="modal" type="button"><i class="fa fa-xl fa-check"></i></button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/ie10.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script>

$('#brandSelector').change(function(){
	var brandToGet = $("#brandSelector option:selected").val();
	if (brandToGet != '') {
		$.post('brand.php', {name: brandToGet}, function(data) {
			$('#results').html(data);
		});
	};
});
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#matSearch tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>
</body>
</html>