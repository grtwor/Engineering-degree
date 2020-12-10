
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>

<div  class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6);  margin-bottom:5%;">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; margin-bottom:3%;">Brute Force Lab 1</h4>

</div>
	<div class="row" style="height:500px !important; padding:3%;">
		<div class="col-12">
			<?php 
				error_reporting(0);
				if ($_SESSION['sqli'] == "NO")
				{
					echo'
					<div class="card bg-dark col-4" id="loginform" style=" margin:auto; padding-bottom:2%;" > 
						<div class="card-body " style="padding-bottom:0%; padding-top:5%;">


							<h4 style="color:#b1de35;">Sign in Panel</h4> <!-- FORMULARZ LOGOWANIA -->
							<form method="POST" action="/lab">
								<div style="margin-bottom:0%; margin-top:5%;">
									<input class="form-control" placeholder="Login" type="text" name="ulogin" required>
								</div>
								<div  style="margin-bottom:5%; margin-top:5%;">
									<input class="form-control " placeholder="Password" type="password" name="upassword" required>
								</div>
								<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="log"><i class="fas fa-sign-in-alt"></i> Sign in </button>
							</form>
						</div>
					</div>';
					if(isset($_POST['ulogin']) && ($_POST['upassword'] == true))
					{ 
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_brute';
						$connect = mysqli_connect($server, $user, $password, $baza);


						$login = $_POST['ulogin'];
						$pass = $_POST['upassword'];
						


						$query = mysqli_query($connect,"SELECT * FROM users WHERE login = '$login' AND password = '$pass'");
						$goodlogin = mysqli_query($connect,"SELECT * FROM users WHERE login = '$login'");
						$goodpass = mysqli_query($connect,"SELECT * FROM users WHERE password = '$pass'");


						if(mysqli_num_rows($query) > 0){
							$_SESSION['sqli'] = "logged";
							$_SESSION['sqlilogin'] = $login;
							


							echo"<script type='text/javascript'>
							//Place as last thing before the closing </body> tag
							if(location.search.indexOf('reloaded=yes') < 0){
							var hash = window.location.hash;
							var loc = window.location.href.replace(hash, '');
							loc += (loc.indexOf('?') < 0? '?' : '&') + 'reloaded=yes';
							// SET THE ONE TIME AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS):
							setTimeout(function(){window.location.href = loc + hash;}, 1);
							}
							</script>";	
						}
						else if(mysqli_num_rows($goodlogin) > 0){
							echo "<div class='container-fluid bg-dark col-4' style='border-radius:5px;'><p class='text-warning text-center' style='margin:auto; margin-bottom:0%; margin-top:3%;'>Wrong password</p></div>";
						}
						else if(mysqli_num_rows($goodpass) > 0){
							echo "<div class='container-fluid bg-dark col-4' style='border-radius:5px;'><p class='text-warning text-center' style='margin:auto; margin-bottom:0%; margin-top:3%;'>Wrong login</p></div>";
						}
						else
						{
							echo "<div class='container-fluid bg-dark col-4' style='border-radius:5px;'><p class='text-warning text-center' style='margin:auto; margin-bottom:0%; margin-top:3%;'>Wrong login or password</p></div>";
						}
					}
					
				}
			?>

			<?php 
				if ($_SESSION['sqli'] == "logged")
				{
					echo"<div class='row justify-content-center' style='margin:auto; color:#b1de35;'><h1>Welcome back tester!</h1></div>";
					echo'
					<script>
						loginform.classList.add("d-none"); 				
					</script
					<div class="container-fluid">
						<div class="col-12" >
							<form  method="GET" action="/lab">
								<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%;" class="float-right btn button form_buttons float-left" name="sign-out"><i class="fas fa-sign-out-alt"></i> Sign out </button>
							</form>
						</div>
					';

					$server='localhost';
					$user='root';
					$password='P@rtyboy1.';
					$baza='labdatabase';
					$connect = mysqli_connect($server, $user, $password, $baza);
					$sql = "SELECT ID from uzytkownicy WHERE login = '".$_SESSION['login']."'"; //WYCIĄGNIJ ID USERA W CELU WYKORZYSTANIA W KOLEJNYCH ZAPYTANIACH
					$result = $connect->query($sql);
					while($row = mysqli_fetch_array($result)) {
						$id= $row['ID']; 
									
					}
					$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 5 AND course_content.title = 'Lab 1 - Username enumeration via different responses') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
					mysqli_query($connect, $sql);
					//$_SESSION['lab'] = "/lab";
					//$_SESSION['lab_switch'] = 0;
					//echo'
					//<script>
					//	setTimeout(function(){ document.getElementById("ModalButton").click();; }, 1000);
					//</script>';
					echo'
					<script type="text/javascript">			
						setTimeout(function(){ toastr.success("Congratulation! You have just completed the laboratory!");; }, 1000);
					</script>';


					if(isset($_GET['sign-out'])){
						$_SESSION['sqli'] = "NO";
						$_SESSION['sqlilogin'] = "";
						echo"<script type='text/javascript'>
						//Place as last thing before the closing </body> tag
						if(location.search.indexOf('reloaded=yes') < 0){
						var hash = window.location.hash;
						var loc = window.location.href.replace(hash, '');
						loc += (loc.indexOf('?') < 0? '?' : '&') + 'reloaded=yes';
						// SET THE ONE TIME AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS):
						setTimeout(function(){window.location.href = loc + hash;}, 1);
						}
						</script>";	
					}	
					echo "</div>";
				}
				
				
			?>				
</div>

<div class="fixed-bottom container-fluid" style="margin:auto;">
	<?php 
		require_once("footer.php"); 
	?>
</div>