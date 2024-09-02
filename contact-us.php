<?php

/*

*/
//this is where you will edit your email address

$my_email = "EMAIL_ADDRESS";

//this is where the follow page will go e.g anything at wherever --blah blah blah
$continue = "index.html";



$errors = array();

// Remove $_COOKIE elements from $_REQUEST.

if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}

// Check all fields for an email header.

function recursive_array_check_header($element_value)
{

global $set;

if(!is_array($element_value)){if(preg_match("/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i",$element_value)){$set = 1;}}
else
{

foreach($element_value as $value){if($set){break;} recursive_array_check_header($value);}

}

}

recursive_array_check_header($_REQUEST);

if($set){$errors[] = "You cannot send an email header";}

unset($set);

// lets make sure everything works

if(isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{

if(preg_match("/(%0A|%0D|\n+|\r+|:)/i",$_REQUEST['email'])){$errors[] = "Email address may not contain a new line or a colon";}

$_REQUEST['email'] = trim($_REQUEST['email']);

if(substr_count($_REQUEST['email'],"@") != 1 || stristr($_REQUEST['email']," ")){$errors[] = "Email address is invalid";}else{$exploded_email = explode("@",$_REQUEST['email']);if(empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1])){$errors[] = "Email address is invalid";}else{if(substr_count($exploded_email[1],".") == 0){$errors[] = "Email address is invalid";}else{$exploded_domain = explode(".",$exploded_email[1]);if(in_array("",$exploded_domain)){$errors[] = "Email address is invalid";}else{foreach($exploded_domain as $value){if(strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value)){$errors[] = "Email address is invalid"; break;}}}}}}

}

// Check & make sure this is from the same site.

if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}

// Check for a blank form or bot.

function recursive_array_check_blank($element_value)
{

global $set;

if(!is_array($element_value)){if(!empty($element_value)){$set = 1;}}
else
{

foreach($element_value as $value){if($set){break;} recursive_array_check_blank($value);}

}

}

recursive_array_check_blank($_REQUEST);

if(!$set){$errors[] = "You cannot send a blank form please enter something";}

unset($set);

// Display any errors.

if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}

if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}

// Build message.

function build_message($request_input){if(!isset($message_output)){$message_output ="";}if(!is_array($request_input)){$message_output = $request_input;}else{foreach($request_input as $key => $value){if(!empty($value)){if(!is_numeric($key)){$message_output .= str_replace("_"," ",ucfirst($key)).": ".build_message($value).PHP_EOL.PHP_EOL;}else{$message_output .= build_message($value).", ";}}}}return rtrim($message_output,", ");}

$message = build_message($_REQUEST);

$message = $message . PHP_EOL.PHP_EOL."".PHP_EOL."";

$message = stripslashes($message);

$subject = "Meals on Wheels of Hamilton County";

$headers = "From: " . $_REQUEST['email'];
$headers .= PHP_EOL;
$headers .= "Return-Path: " . $_REQUEST['email'];
$headers .= PHP_EOL;
$headers .= "Reply-To: " . $_REQUEST['email'];

mail($my_email,$subject,$message,$headers);

?>
<!doctype html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Saucepan Creative" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="shortcut icon" type="image/ico" href="favicon.ico" />

	<title>Contact Meals on Wheels of Hamilton County</title>

	<link type="text/css" href="css/screen.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/print.css" rel="stylesheet" media="print" />

	<script type="text/javascript" src="script/jquery.js"></script>
	<script type="text/javascript" src="script/cycle.js"></script>
	<script type="text/javascript" src="script/easing.js"></script>
	<script type="text/javascript" src="script/settings.js"></script>

	<script type="text/javascript" src="script/truncate.js"></script>
	<script type="text/javascript" src="script/limit.js"></script>

	<!--[if IE 6]>
		<script src="script/transparency.js"></script>
		<script src="script/png.js"></script>
	<![endif]-->

</head>

<body class="contact">

	<!-- Header -->

	<div id="header">

		<h1><a href="index.html" title="Meals on Wheels">Meals on Wheels of Hamilton County</a></h1>

		<ul id="navigation">
			<li id="about-us"><a href="about-us.html" title="About Us">About Us <em>Our Mission</em></a></li>
			<li id="services"><a href="services.html" title="Services">Services <em>Services We Provide</em></a></li>
			<li id="volunteer"><a href="volunteer.html" title="Volunteer">Volunteer <em>Volunteer Opportunities</em></a></li>
			<li id="donate"><a href="donate.html" title="Donate">Donate <em>Support Our Mission</em></a></li>
			<li id="blog"><a href="http://www.mealsonwheelshc-blog.org" title="Blog">Blog <em>Brief Detail</em></a></li>
			<li id="contact"><a href="contact-us.html" title="Contact Us">Contact <em>Contact Us Today</em></a></li>
		</ul>

		<p class="promotion sponsor-a-senior"><a href="donate.html" title="Sponsor a senior today!">Sponsor a senior today!</a></p>

		<div id="slides">

			<div class="slide">

				<img src="media/slide/01.png" alt="Can you donate the next meal?" />

				<div class="message">

					<h2>Can <em>you</em> donate the next meal?</h2>

					<p>Help sponsor a senior who is in need of covering the cost of daily meals.</p>

				</div>

			</div>

			<div class="slide">

				<img src="media/slide/02.png" alt="Our neighbors are hungry." />

				<div class="message">

					<h2><em>Our</em> neighbors are hungry.</h2>

					<p>Help sponsor a senior who is in need of covering the cost of daily meals.</p>

				</div>

			</div>

			<div class="slide">

				<img src="media/slide/03.png" alt="Our mothers are hungry." />

				<div class="message">

					<h2><em>Our</em> mothers are hungry.</h2>

					<p>Help sponsor a senior who is in need of covering the cost of daily meals.</p>

				</div>

			</div>

		</div>

		<div id="news">

			<h3>News</h3>

			<p><a href="blog.html#holidays" title="Read more.">Meals will not be delivered on the following holidays: New Years Day, Memorial Day, July 4th, Labor Day and Thanksgiving.</a></p>

		</div>

	</div>

	<!-- Body -->

	<div id="body">

		<div class="column" id="left">

			<h2>Contact Us</h2>

			<div id="stylesheet-switcher">

				<p class="color light"><a href="#" title="Change colors to a lighter theme.">Change colors to a light theme.</a></p>

				<ul id="text">
					<li id="decrease"><a href="#" title="Decrease size of text.">Decrease size of text.</a></li>
					<li id="increase"><a href="#" title="Increase size of text.">Increase size of text.</a></li>
				</ul>

			</div>

			<form>

				<ol>
					<li>
						<label for="name">Name</label>
						<input name="Name" type="text" />
					</li>
					<li>
						<label for="address">Address</label>
						<input name="Address" type="text" />
					</li>
					<li>
						<label for="phone">Phone</label>
						<input name="Phone" type="text" />
					</li>
					<li>
						<label for="e-mail">E-mail</label>
						<input name="E-mail" type="text" />
					</li>
					<li>
						<label for="message">Message</label>
						<textarea name="Message"></textarea>
					</li>
				</ol>

				<input name="Submit" type="image" src="media/send-message.png" />

			</form>

		</div>

		<div class="column" id="right">

			<div id="mailing-address">

				<h3><em>Mailing</em> Address</h3>

				<ul>
					<li>Meals on Wheels of Hamilton County, Inc.</li>
					<li>395 Westfield Road</li>
					<li>Noblesville, IN 46060-1425</li>
					<li>Phone: (317) 776-7159</li>
					<li>Fax: (317) 770-2971</li>
				</ul>

			</div>

			<p id="good-search"><a href="" title="Good Search">Good Search</a></p>

			<div id="upcoming-events">

				<h3><em>Upcoming</em> Events</h3>

				<div class="event top">

					<ul class="date">
						<li class="month">Apr</li>
						<li class="day">21</li>
						<li class="year">2010</li>
					</ul>

					<h4><a href="" title="Volunteer Appreciate Banquet">Volunteer Appreciate Banquet</a></h4>

					<p class="time">6:30 &ndash; 9:30pm</p>

				</div>

				<div class="event middle">

					<ul class="date">
						<li class="month">Apr</li>
						<li class="day">30</li>
						<li class="year">2010</li>
					</ul>

					<h4><a href="" title="Hoosier Derby Party">Hoosier Derby Party</a></h4>

					<p class="time">6:30 &ndash; 9:30pm</p>

				</div>

				<div class="event bottom">

					<ul class="date">
						<li class="month">Aug</li>
						<li class="day">6</li>
						<li class="year">2010</li>
					</ul>

					<h4><a href="" title="Hoosier Derby Party">10th Annual Strikeout Hunger Bowl-A-Thon</a></h4>

					<p class="time">6:30 &ndash; 9:30pm</p>

				</div>

				<p class="read-more"><a href="" title="View more upcoming events.">Read more&hellip;</a></p>

			</div>

		</div>

	</div>

	<!-- Footer -->

	<div id="footer">

		<p id="copyright">Copyright &copy; 2010, Meals on Wheels of Hamilton County.</p>

	</div>

</body>

</html>
