<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>:: Shaghaf ::</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="assets/slider/owl.carousel.css">
<link rel="stylesheet" href="assets/flipclock/flipclock.css">

<style>
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro);
*{font-family: 'Source Sans Pro', sans-serif; color:#fff;padding:0px;margin:0px;}
.green{ background-color:#108a94;}
.header{ background-color:white;}

@media screen and (max-width: 480px) {
    .leftlogo {
        padding-top: 30px;
    }
	.rightlogo img{ padding-bottom:10px;}
}
@media screen and(min-width:720px){
	.leftlogo {
        padding: 10px;
    }
	}
.rightlogo{text-align:right; padding:10px; padding-top:30px;}
.rightlogo img{float:right;}
.menu{ color:#fff; padding-top:10px; font-size:14pt; font-weight:bold; text-align:right;}
.slider{}
.about{ color:#fff; padding:20px;}
.about h3{ text-align:center;}
.about p{ text-align:center; padding-top:5px;}
.login{ width:90%; margin:0px auto;}
.signup{}
.margin-menu{    margin-bottom: 10px;
    margin-top: 10px;}
.list-inline>li{ margin:10px;}
.clock{ width:350px; margin:40px auto;}
.footer{ text-align:center;  margin-top:20px; margin-bottom:20px; font-size:9pt;}
.time{  margin:10px; top:10px;}
.pinkcolor{ background-color:#DB386C;} 
.row{margin:0px;}
a{ color:#fff;}
a:hover{ text-decoration:none; color:#DB386C;}
</style>
</head>

<body>

<div class="container" style="padding:0px; margin:0px auto;">
<div class="row header">
<div class="col-xs-6"><div class="leftlogo"><img src="images/kkflogo.jpg" class="img-responsive" /></div></div>
<div class="col-xs-6"><div class="rightlogo"><img src="images/shaghaflogo.png"  class="img-responsive"/></div></div>
</div>
<div class="row green margin-menu">
<div class="col-xs-12"><div class="menu">
<ul class="list-inline">
<li><a href="index.php">HOME</a></li>
<li><a href="http://www.kkf.org.sa/ar/ProgramsAndGrants/Programs/CBForNPOs/Shaghaf/Pages/default.aspx" >ABOUT</a></li>
<li><a href="faq.php">FAQ</a></li>
</ul></div></div>
</div>

<div class="row">

<div class="col-lg-12" style="padding:0px;"><div class="slider">

  <div> <img src="images/1.jpg" /> </div>
  <div> <img src="images/2.jpg" /> </div>
  <div> <img src="images/3.jpg" /> </div>
 

</div></div>
<div class="col-lg-12" style="padding:0px">
<div class="about green">
<h3>About The Program</h3>
<p>A non-profit fellowship program under the name “Shaghaf” brought to you by King Khalid Foundation and the Bill and Melinda Gates Foundation, to support the effectiveness of the NPO sector in the Kingdom of Saudi Arabia for the short and long term, as well as to improve the level of services provided by orgnizations to their community. </p>
</div>

</div>
<div class="col-lg-12 green"  style="padding:0px">
	<div class="row">
    	<div class="col-lg-6">
        <div class="login">
        <h3>Login Area</h3>
        <form>
            <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-block pinkcolor" id="submit" value="Login">
            </div>            
        </form>
        </div>
        </div>
        <div class="col-lg-6"><div class="time"><h3>Sign up will start after :</h3><div class="clock"></div>
        </div>
</div>
    </div>
<div class="col-lg-12"><div class="footer">Copyright &copy; King Khalid Foundation and Bill and Melinda Gates Foundation 2016 All rights reserved</div></div>    
</div>

</div>




</div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="assets/slider/owl.carousel.min.js"></script>
<script src="assets/flipclock/flipclock.min.js"></script>
<script>
$(document).ready(function(){
  $(".slider").owlCarousel({ items:1,autoplay:true});
});
</script>

<script type="text/javascript">
$(document).ready(function(e) {
	// Grab the current date
				var currentDate = new Date();
var target = new Date('April 10, 2016');
    var diff = target-(currentDate.getTime() / 1000);

	var clock = $('.clock').FlipClock(target, {
		clockFace: 'DailyCounter',
		countdown: true,
		showSeconds:false
		
	});
});
	
</script>
</body>
</html>