<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Main Page</title>
	<link rel="stylesheet" href="/styles/bootstrap.min.css">
	<link rel="stylesheet" href="/styles/font-awesome.min.css">
	<link rel="stylesheet" href="/styles/style.css">

	<script src="/scripts/a076d05399.js"></script>
	<script src="/scripts/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="/scripts/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="/scripts/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</head>
    
<body class="" style="background-image: url('img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">
	<div class="container-fluid" style="margin:auto; margin-top:18%;"> 
	<div class="row">
		<h4 class="" style="color:#b1de35; margin:auto; ">It is your first sign in session so please change default password</h4>
	</div>
	<div class="row">
		<div class="col-sm-2" style="margin:auto; margin-top:2%;">
			
			<form method="POST" action="">
				<div style="margin-bottom:5%; margin-top:5%;">
					<input class="form-control" placeholder="new password" type="password" name="pass_new" required>
				</div>
				<div>
					<input class="form-control " placeholder="confirm new password" type="password" name="pass_new_conf" required>
				</div><br>
				<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="log_first"><i class='fas fa-sign-in-alt'></i> Sign in </button>
			</form>

			<?php
				if ((isset($_POST['pass_new']) && ($_POST['pass_new_conf'])) && ($_POST['pass_new'] == $_POST['pass_new_conf']) ) //JESLI USER WYPELNIL WSZYSTKIE POLA I PODANE HASLA SA TAKIE SAME TO...
				{  
				session_start();
					$server='localhost';
					$user='root';
					$password='P@rtyboy1.';
					$baza='labdatabase';

					$pass = $_POST['pass_new'];
					$pass = password_hash($pass, PASSWORD_BCRYPT);
					$connect = mysqli_connect($server, $user, $password, $baza);
					$sql = "UPDATE uzytkownicy SET pass_set_by_user = 'YES' WHERE login = '".$_SESSION['login']."' "; //ZAKTUALZUJ DANE W BAZIE ZE USER USTAWIL JUZ SWOJE HASLO I ZESWOL NA DOSTEP
					mysqli_query($connect, $sql);
					
					$sql = "UPDATE uzytkownicy SET password = '$pass' WHERE login = '".$_SESSION['login']."' "; //ZAKTUALZUJ DANE W BAZIE ZE USER USTAWIL JUZ SWOJE HASLO I ZESWOL NA DOSTEP
					mysqli_query($connect, $sql);
					
					$_SESSION['userpass'] = "YES";  //UAKTUALNIENIE ZMIENNEJ W SESJI ODNOSNIE STATUSU HASLA
						header('Location:home'); //PRZENIES NA STR DOMOWA HOME
						exit();

				}elseif((isset($_POST['pass_new']) && ($_POST['pass_new_conf'])) && ($_POST['pass_new'] != $_POST['pass_new_conf'])){

					echo"
					<script>
						toastr.warning('Provided passwords are different');
					</script>";
				}
				if(isset($_SESSION['error']))
					echo'<div class="container-fluid col-sm-2"> '.$_SESSION['error'].' </div> ';
				?>
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