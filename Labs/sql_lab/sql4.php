
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>

<div  class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6);  margin-bottom:5%;">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; margin-bottom:3%;">SQL LAB 4</h4>

</div>
	<div class="row" style="height:500px !important; padding:3%;">
		<div class="col-12">
			<?php 
				error_reporting(0);
				ini_set('display_errors', 0);
				
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
						;
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_sql';
						$connect = mysqli_connect($server, $user, $password, $baza);


						$login = $_POST['ulogin'];
						$pass = $_POST['upassword'];
						
						if (strpos($login, '--') !== false) {
							str_replace("--","",$login);
						}

						$query = mysqli_query($connect,"SELECT * FROM users WHERE login = '$login' AND password = '$pass'");
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
					$sqlilogin = $_SESSION['sqlilogin'];
					if(isset($_COOKIE['trackingID'])) // DO LABA SQL4 SPROBOWAC PRZENIESC DO SQL4.PHP
					{
						echo"<div class='row justify-content-center' style='margin:auto; color:#b1de35;'><h1>Welcome back $sqlilogin !</h1></div>";
					}
					else
					{
						echo"<div class='row justify-content-center' style='margin:auto; color:#b1de35;'><h1>It is your first visit here $sqlilogin !</h1></div>";	
					}		
					
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



					if(isset($_GET['sign-out'])){
						$_SESSION['sqli'] = "NO";
						$_SESSION['sqlilogin'] = "";
						echo"<script type='text/javascript'>
									//Place as last thing before the closing </body> tag
									if(location.search.indexOf('r') < 0){
									var hash = window.location.hash;
									var loc = window.location.href.replace(hash, '');
									loc += (loc.indexOf('?') < 0? '?' : '&') + 'r';
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