<form  method="POST" action="/lab" >
			<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
			<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
		</form>
<div class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6);">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%;">CSRF LAB 1</h4></div>
	<div class="row" style="height:500px !important; padding:3%;">
		<div class="col-6">


			<?php 
				if ($_SESSION['csrf'] == "NO")
				{
					echo'
					<div class="card bg-dark col-8" id="loginform" > 
						<div class="card-body " style="padding-bottom:10%; padding-top:5%;">


							<h4 style="color:#b1de35;">Sign in Panel</h4> <!-- FORMULARZ LOGOWANIA -->
							<form method="POST" action="lab">
								<div style="margin-bottom:5%; margin-top:5%;">
									<input class="form-control" placeholder="Login" type="text" name="ulogin" required>
								</div>
								<div  style="margin-bottom:5%; margin-top:5%;">
									<input class="form-control " placeholder="Password" type="password" name="upassword" required>
								</div>
								<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="log"><i class="fas fa-sign-in-alt"></i> Sign in </button>
							</form></div>';
							
				}
				?>
				<?php
			
				
					
					if(isset($_POST['ulogin']) && ($_POST['upassword'] == true)){ 
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_csrf';
						$connect = mysqli_connect($server, $user, $password, $baza);


						$login = $_POST['ulogin'];
						$pass = $_POST['upassword'];
						


						$query = mysqli_query($connect,"SELECT * FROM users WHERE login = '$login' AND password = '$pass'");
    					if(mysqli_num_rows($query) > 0){
							$_SESSION['csrf_email'] = "franek@email.com";
							$_SESSION['csrf'] = "logged";
							$_SESSION['csrflogin'] = $login;
							


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
					}
					if(isset($_SESSION['error']))
					{
						echo'<div class="container-fluid col-sm-2"> '.$_SESSION['error'].' </div></div> ';
						
					}
				
				
			
			
				if ($_SESSION['csrf'] == "logged")
				{
					$server='localhost';
					$user='root';
					$password='P@rtyboy1.';
					$baza='labdb_csrf';
					$connect = mysqli_connect($server, $user, $password, $baza);
					$sql = "SELECT email from users WHERE login = 'franek';";
					$query = mysqli_query($connect, $sql);
					$row = mysqli_fetch_array($query);
					$emailcurrent = $row['email']; 	
					echo'
					<script>
						loginform.classList.add("d-none"); 				
					</script>
					<div class="row">
						<div class="col-6">
							<div class="card bg-dark " style="margin-bottom:7%; margin-top:10%;  "> 
									<div class="card-body " style="padding-bottom:10%; padding-top:5%;">
										<h4 id="result"  style="color:#b1de35;">Welcome back '.strip_tags($_SESSION['csrflogin']).' </h4> <!-- Hej!-->
										<h4 style="color:#b1de35;">Your email is: '.$emailcurrent.' </h4>
									</div>
							</div>
							<form method="POST" action="lab">
								<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; " class="btn button form_buttons float-left" name="sign-out"><i class="fas fa-sign-out-alt"></i> Sign out </button>
							</form>
							
						</div>
						<div class="col-6">
							<div class="card bg-dark" style="margin-bottom:7%; margin-top:10%;  "> 
							<div class="card-body " style="padding-bottom:10%; padding-top:10%;">


								<h4 style="color:#b1de35;">CHANGE EMAIL</h4> <!-- EMAIL CHANGE -->
								<form method="POST" action="lab" name="changemailform">
									<div style="margin-bottom:5%; margin-top:5%;">
										<input class="form-control" placeholder="new email" type="email" name="emailnew">
									</div>
									<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; " class="btn button form_buttons float-left" name="emailsubmit"><i class="fas fa-pencil-alt"></i> Change email </button>
								</form>
							</div>
						</div>
					</div>
					';
					
					if(isset($_POST['emailnew']) AND ($_POST['emailnew'] != ""))
					{ 
						$email = strip_tags($_POST['emailnew']);
						$login = $_SESSION['csrflogin'];
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_csrf';
						$connect = mysqli_connect($server, $user, $password, $baza);

						$sql = "UPDATE users SET email = '$email' WHERE login = 'franek';";

						$query = mysqli_query($connect, $sql);
						if($_SESSION['exploit_delivered'] != "Delivered"){
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

						
					}
					



					if($_SESSION['exploit_delivered'] == "Delivered"){
						
						
						$login = $_SESSION['csrflogin'];
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_csrf';
						$connect = mysqli_connect($server, $user, $password, $baza);


						$sql = "SELECT email from users WHERE login = 'franek'";
						$query = mysqli_query($connect, $sql);
							
						$row = mysqli_fetch_array($query);
						
						
						
						if($row['email'] != $_SESSION['csrf_email']){
							echo"<script>document.getElementById('commit').click();</script>";
						}
						
						$_SESSION['exploit_delivered'] = "NO";
					}	
					

				}
				if(isset($_POST['sign-out'])){
					$_SESSION['csrf'] = "NO";
					$_SESSION['csrflogin'] = "";
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
			

				
			?>
			<?php
							
				if(isset($_POST["complete"]))
				{
					if(TRUE) // JEŚLI KRYTERIA UKOŃCZENIA LAB ZOSTANĄ WYKONANE TO ZUPADTUJ DB ORAZ ODLACZ BATERIE Z LABORATORIUM
					{
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
						$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 1 AND course_content.title = 'Lab 1 - CSRF without any prevention mechanism implemented') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
						mysqli_query($connect, $sql);
						//$_SESSION['lab'] = "/lab";
						//$_SESSION['lab_switch'] = 0;
						//$_SESSION['csrf'] = "NO";
						//$_SESSION['csrflogin'] = "";

						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_csrf';
						$connect = mysqli_connect($server, $user, $password, $baza);

						//$sql = "UPDATE users SET email = 'franek@email.com' WHERE login = 'franek';";

						//$query = mysqli_query($connect, $sql);	

					//echo'
					//<script>
					//	//setTimeout(function(){labcore.classList.add("d-none");; }, 1000);
					//	setTimeout(function(){ document.getElementById("ModalButton").click();; }, 1000);
					//</script>';
					echo'
					<script type="text/javascript">			
						setTimeout(function(){ toastr.success("Congratulation! You have just completed the laboratory!");; }, 1000);
					</script>';

					}

								
				}
			
			?>
	</div>	
						
</div>

<div class="fixed-bottom container-fluid" style="margin:auto;">
	<?php 
		require_once("footer.php"); 
	?>
</div>