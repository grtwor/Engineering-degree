<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['login']) or ($_SESSION['type'] != "admin") ){
		header('Location:home');
		exit();
	}
?>
<html>
	<head>
		<title>Dashboard</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	

		<style>
		.nav-item{margin-left:3%;}
		
		</style>
	</head>
		
	<body class="" style="background-image: url('img/bg_test.png');background-repeat: auto; background-size: 1920px 1080px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("nav.php"); ?>
				</div>
				
				<div class="col-sm-9" style="">
					<div class="row"><h4 style="color: #d1ff52;  margin-top:1%;">Dashboard</h4></div>
					</div>
				</div>
			</div>
		</div>
		<div class="fixed-bottom container-fluid" style="margin:auto;">
            <?php 
                require_once("footer.php"); 
            ?>
        </div>
	</body>

</html>