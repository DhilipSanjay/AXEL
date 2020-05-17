<?php

include("dbconnect.php"); 

?>


<!DOCTYPE html>

    <html class="no-js"> 
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>News - Axel</title>
	<link rel="icon" href="logo.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic|Roboto:400,300,700' rel='stylesheet' type='text/css'>
	<!-- Animate -->
	<link rel="stylesheet" href="news/css/animate.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="news/css/bootstrap.css">

	<link rel="stylesheet" href="news/css/style.css">

	</head>
	<body>

		
	<!-- END #fh5co-offcanvas -->
	<header id="fh5co-header">
		
		<div class="container-fluid">

				<div class="col-lg-12 col-md-12 text-center">
					<h1 id="fh5co-logo">Axel Stories</h1>
				</div>
        </div>
        
	</header>
	

	<div class="container-fluid">
		<div class="row fh5co-post-entry">

		<hr style="width:90%;border-bottom:0.5px solid #76D7C4;height:0;margin-bottom:75px">

	<?php
	$query="SELECT title,minuteread,description,url,DATE_FORMAT(createdtime,'%d %M %Y') as createdtime FROM news ORDER BY createdtime desc"; 
	$result=mysqli_query($conn,$query);
	$temp=1;
	$imgcount=0;
	$imagesarr = array("news/images/pic_1.jpg","news/images/pic_2.jpg","news/images/pic_3.jpg","news/images/pic_4.jpg");
	
	
	while($row=mysqli_fetch_array($result))
	{
	?>

			<article class="col-lg-3 col-md-3 col-sm-3 col-xs-6 col-xxs-12 animate-box">
				<figure>
					<a href="<?php echo $row["url"] ?>" target="_blank"><img src="<?php echo $imagesarr[$imgcount] ?>" alt="Image" class="img-responsive"></a>
				</figure>
                <div><?php echo $row["minuteread"]." minute read" ?></div>
                </span>
				<h2 class="fh5co-article-title"><a href="<?php echo $row["url"] ?>"  target="_blank"><?php echo $row["title"] ?></a></h2>
				<span class="fh5co-meta fh5co-date"><?php echo $row["createdtime"] ?></span>
			</article>
			<!--<div class="clearfix visible-xs-block"></div>-->

			
	<?php

	if($temp%4===0)
	{
	?>
		<div class="clearfix visible-lg-block visible-md-block visible-sm-block visible-xs-block"></div>
		

	<?php
	$imgcount=0;
	}

	$temp++;
	$imgcount++;
	 } 
	?>


		</div>
	</div>

	<footer id="fh5co-footer">
		<p><small>&copy; 2020. Axel. All Rights Reserved.</small></p>
	</footer>


	
	<!-- jQuery -->
	<script src="news/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="news/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="news/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="news/js/jquery.waypoints.min.js"></script>
	<!-- Main JS -->
	<script src="news/js/main.js"></script>

	</body>
</html>
