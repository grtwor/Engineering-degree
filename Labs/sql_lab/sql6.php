
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>

<div  class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6); ">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; margin-bottom:3%;">SQL LAB 6</h4></div>
	<div class="row" style=" padding:3%;">
		<div class="col-12">

				<?php
					if(( $_SESSION['sqli'] == "NO")){
						echo'
						<script>
							loginform.classList.add("d-none"); 	
							goback.classList.add("d-none");			
						</script>
						<div class="container-fluid">
							<div class="col-12" >
								<form  method="GET" action="/lab" id="docshide">
									<button type="submit" id="showdocs" value="all" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="fas fa-calendar-alt"></i> All Docs </button>
									<button type="submit" id="showdocs19" value="2019" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="far fa-calendar-alt	"></i> 2019 Docs </button>
									<button type="submit" id="showdocs20" value="2020" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="far fa-calendar-alt	"></i> 2020 Docs </button>

								</form>
								<form  method="POST" action="/lab" >
									<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-left:2%; " class=" float-right btn button form_buttons float-left" name="sign-in"><i class="fas fa-sign-in-alt"></i> Account login </button>
									<button type="submit" id="goback" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; " class="d-none float-right btn button form_buttons float-left" name="goback"><i class="fas fa-sign-in-alt"></i> Go back to content </button>
								</form>
							</div>
						</div>
						';
					}
						//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
				 
						error_reporting(0);
						if ((($_SESSION['sqli'] == "NO") && (isset($_POST['sign-in']))) || $_SESSION['sqlilogin'] == "wronglogin")
						{
							
							echo'
							<script>
								docshide.classList.add("d-none"); 
								goback.classList.remove("d-none");				
							</script>';

							echo'
							</div><div class="container-fluid" style="height:410px !important;">
								<div class="card bg-dark col-4" id="loginform" style=" margin:auto; padding-bottom:2%; " > 
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
								</div>
							</div>';	
						}
						if(isset($_POST['ulogin']) && (isset($_POST['upassword']) ))
						{ 
							echo'
							<script>
								docshide.classList.add("d-none"); 
								goback.classList.remove("d-none");				
							</script>';

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
								echo'
								<script>
								
									docshide.classList.add("d-none"); 
									goback.classList.add("d-none");				
								</script>';
								
								$_SESSION['sqli'] = "logged";
								$_SESSION['sqlilogin'] = $login;




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
							else
							{
								$_SESSION['sqlilogin'] = "wronglogin";
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
						if($_SESSION['sqlilogin'] == "wronglogin")
						{
							echo'
							<script>
								setTimeout(function(){ wrong.classList.remove("d-none");; }, 500);
							</script>';
							echo "<div id='wrong' class=' d-none container-fluid bg-dark col-4' style='border-radius:5px; margin-top:0%;'><p class='text-warning text-center' style='margin:auto; margin-bottom:1%; margin-top:1%;'>Wrong login or password</p></div>";

						}

					
						if ($_SESSION['sqli'] == "logged")
						{


							echo"<script type='text/javascript'>
							setTimeout(function(){ 
							//Place as last thing before the closing </body> tag
							if(location.search.indexOf('r') < 0){
							var hash = window.location.hash;
							var loc = window.location.href.replace(hash, '');
							loc += (loc.indexOf('?') < 0? '?' : '&') + 'r';
							// SET THE ONE TIME AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS):
							setTimeout(function(){window.location.href = loc + hash;}, 1);
							}; }, 1000);
							</script>";
							echo"<div class='row justify-content-center' style='margin:auto; color:#b1de35;'><h1>Welcome back ".$_SESSION['sqlilogin']." !</h1></div>";
							echo'
							<script>
							
								loginform.classList.add("d-none"); 				
							</script
							<div class="container-fluid">
								<div class="col-12" >
									<form  method="POST" action="/lab">
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
							if($_SESSION['sqlilogin'] == "admin"){
								$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 3 AND course_content.title = 'Lab 6 - SQL injection UNION attack, retrieving multiple values in a single column') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
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
						}
	
	
							if(isset($_POST['sign-out'])){
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
						if(isset($_POST['goback']))
						{
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
					
					
							
				
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
						
						if(isset($_GET['show_docs'])  && ($_SESSION['sqli'] == "NO")  && $_SESSION['sqlilogin'] != "wronglogin" )
						{
							$data = $_GET['show_docs'];
							$server='localhost';
							$user='root';
							$password='P@rtyboy1.';
							$baza='labdb_sql';
							$connect = mysqli_connect($server, $user, $password, $baza);
							
							echo'
							<div class="container-fluid" style=" overflow: auto; height:450px; margin-bottom:%; display:block;">
								<table class="table table-hover table-dark">
									<thead>
										<tr>
										<th scope="col">ID</th>
										<th scope="col">name</th>
										</tr>
									</thead>
									<tbody>

								
								';
									if($_GET['show_docs'] == "all")
									{
										$sql = "SELECT ID, name FROM docs WHERE sensitiveData = 0  "; 
									}
									elseif($_GET['show_docs'] != "all")
									{
										$sql = "SELECT ID, name FROM docs WHERE YEAR(created) = '$data' AND sensitiveData = 0  ";
									}
																	
									
									$result = $connect->query($sql);
									$counter = 0;

									while($row = mysqli_fetch_array($result)) 
									{

										$ID =  $row['ID'];
										$name =  $row['name'];

										//$sensitiveData =  $row['sensitiveData'];
										$counter += 1;
										

										echo'
										<tr>
											<td>'.$ID.'</td>
											<th scope="row">'.$name.'</th>

											
										</tr>';
										
									}
									

								echo '
									</tbody>
								</table>
							</div>';
						}elseif( $_SESSION['sqli'] == "NO" && (!isset($_POST['sign-in'])) && $_SESSION['sqlilogin'] != "wronglogin")
						{
							$data = "all";
							$server='localhost';
							$user='root';
							$password='P@rtyboy1.';
							$baza='labdb_sql';
							$connect = mysqli_connect($server, $user, $password, $baza);
							
							echo'
							<div class="container-fluid" style=" overflow: auto; height:450px; margin-bottom:%; display:block;">
								<table class="table table-hover table-dark">
									<thead>
										<tr>
										<th scope="col">ID</th>
										<th scope="col">name</th>

										</tr>
									</thead>
									<tbody>

								
								';
	
									$sql = "SELECT ID, name FROM docs WHERE sensitiveData = 0  "; 

																	
									
									$result = $connect->query($sql);
									$counter = 0;

									while($row = mysqli_fetch_array($result)) 
									{
									
										$ID =  $row['ID'];
										$name =  $row['name'];

										
										//$sensitiveData =  $row['sensitiveData'];
										$counter += 1;

										echo'
										<tr>
											<td>'.$ID.'</td>
											<th scope="row">'.$name.'</th>

											
											
										</tr>';
										
									}

								echo '
									</tbody>
								</table>
							</div>';
						}

					

					echo"</div>";
						
				?>
				
				
</div>

<div class="fixed-bottom container-fluid" style="margin:auto;">
	<?php 
		require_once("footer.php"); 
	?>
</div>