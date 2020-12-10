<!DOCTYPE html>

<?php
	session_start();
	if(!isset($_SESSION['login']) or ($_SESSION['type'] != "user")){
            header('Location:dashboard.php');
		    exit();
	}
    elseif($_SESSION['type'] == "user"){
        if($_SESSION['userpass'] == "NO")
        {
             header('Location:index_.php');  
             exit();
		}
    }
?>
<html>
	<head>
		<title>Settings</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
	</head>
		
	<body class="" style="background-image: url('img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("nav.php"); ?>
				</div>
				
				<div class="col-sm-9">
					<div class="row">
					<h4 style="color: #d1ff52;  margin-top:1%;">Settings</h4>
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