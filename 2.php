<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Innovative Touch Screens for Home Developers | Forward 4</title>
<link rel="stylesheet" type="text/css" href="include/css/1/main.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
</head>

<body>
<div id="bodyContainer">
	<header>
	<div id="topBar" class="wrap">
    	<div class="innerWrap">
			<div id="logoContainer" class="splitPage">
        		<a href="/"><img src="images/1/logo.png" alt="Forward 4 Logo"/></a>
       		</div>
        	<div id="topBar-infoContainer" class="splitPage">
        		<nav>
        		<a id="topBar-login" href="/login.php">Client Login</a>
        		</nav>
        	</div>
        </div>
	</div>
    <div id="splashContainer" class="wrap">
    	<div id="splashInner" class="innerWrap">
        	<div id="splashHighlight-bg">
            	<h1>Next Generation Touch Screen Innovations</h1>
                <span id="spashText">Harness the latest web technologies and empower both your employees and home buyers with the most user-friendly virtual design software.</span>
                
                <div id="freeDemo-Container">
                	<input id="learnMore" type="button" class="input btninput" value="Learn More">
                    <input id="startDemo" type="button" class="input btninput" value="Free Demo">
                </div>
                <div id="demoForm-Container">
                	<form id="demoForm">
                		<div class="inputContainer">
                			<input id="fname" class="input txtinput" type="text" required placeholder="Your Name">
                		</div>
                		<div class="inputContainer">
                			<input id="company" class="input txtinput" type="text" placeholder="Company Name">
               			</div>
                		<div class="inputContainer">
                			<input id="phone" class="input txtinput" type="text" required placeholder="Phone">
                		</div>
                		<div class="inputContainer">
                			<input id="email" class="input txtinput" type="email" required placeholder="Email">
                		</div>
                		<div class="inputContainer">
                			<input id="submit" class="input btninput" type="submit" value="Start Demo >>">
                		</div>
                	</form>
                </div>
            </div>
        </div>
    </div>
	</header>
    <section>
    <div id="features" class="wrap">
    	<div class="innerWrap">
        	<span id="featuresTop">We Take Interactive Virtual Tours to the Next Level.</span>
            <div id="html5" class="featuredPoints">
            	<i class="fa fa-html5" aria-hidden="true"></i><br>
                <span class="featuredTitle">Latest Technology</span><br>

            </div>
            <div id="updates" class="featuredPoints">
            	<i class="fa fa-clock-o" aria-hidden="true"></i><br>
                <span class="featuredTitle">Real-time Updates</span><br>
                
            </div>
            <div id="stayincontact" class="featuredPoints">
            	<i class="fa fa-users" aria-hidden="true"></i><br>
                <span class="featuredTitle">Stay In Contact</span><br>
                
            </div>
        </div>
    </div>
    </section>
	<footer>
	<div id="footer-container dark">

	</div>
	</footer>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#startDemo").click(function(e) {
		e.preventDefault();
		location.href='http://www.forward4.com/demo/';
		//$("#freeDemo-Container").slideUp('fast');
		//$("#demoForm-Container").slideDown('slow');
	});
});
</script>
</body>
</html>