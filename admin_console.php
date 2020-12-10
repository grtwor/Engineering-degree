<!doctype html>

<?php //JEŚLI ZWYKLY USER PROBOJE WEJSC PO URL TO ZOSTANIE PRZEKIEROWANY DO HOME 
	session_start();
	if(!isset($_SESSION['login']) or ($_SESSION['type'] != "admin") ){
		header('Location:home'); // PRZEKIEROWANIE DO HOME JESLI USER JEST ZALOGOWANY
		exit();
	}
?>
<html>
	<head>
		<title>User Management</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<style>
		.nav-item{margin-left:3%;}
		</style>

		

	</head>
		
	<body class="" style="background-image: url('img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("nav.php"); ?>
					
				</div>
				
				<div class="col-sm-6">
					
					
						<div class="container">
							<div class="card border-0" style="margin-bottom:0%; margin-top:3%; !important; background: rgba(134,142,150,0.6);"> <!-- LABORATORY CONTENT -->
								<div class="card-body">
									<div class="row" >
										<h4 class="text-light" style="margin:auto;">User Management Panel</h4>
									</div>
								</div>
							</div>
						</div>
						<div class="container">
							<div class="list-group" >
								
							<div class="accordion" id="accordion" style="margin-top:1%;">

								<div class=" card  border-0" style="margin:0.5%; border-radius:0;"> <!-- DODAWANIE UZYTKOWNIKA DO BAZY-->
									<div class=" parent1 card-header  border-0 btn button text-left border-dark list-group-item-grey" id="heading1"  style="border-radius:0 ;margin-bottom:0%; " type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
										
											Add user to database
										
										<span class="float-right badge-pill badge-primary">PRD feature</span>
									</div>

									<div id="collapse1" class="collapse content1 border-0" aria-labelledby="heading1" data-parent="#accordion" style="background-color:#d1ff52;  background-image: linear-gradient(#868e96 10%, rgba(134,142,150,0.6), #bbe053 );" >
										
										<div class=" text-justify lab_content border-dark" style="font-size:100%; padding:2%;">
										<form method="POST" action="admin_console">
													
													<div class="row justify-content-center" style=" margin:auto; padding:2%; ">
														<div style=" width:45%;margin-right:5%;">
															<input class="form-control" placeholder="login" type="text" name="login" required>
														</div>
														<div style="width:45%;">
															<input class="form-control" placeholder="password" type="text" name="new-password" required>
														</div>
													</div>
													
												
													<?php 
														$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
														if(!$connect) echo "Blad polaczenia z baza danych!".'<br>'.mysqli_errno;
							
							
														if( isset($_POST['register'])  && isset($_POST['login']) && isset($_POST['new-password'])){ //DODAWANIE USERA DO BAZY WRAZ Z PRZYPISANIEM MU WSZYSTKICH KURSOW JAKIE SĄ W PLATFORMIE
							
															$login =  strip_tags($_POST['login']); 
															$password = strip_tags($_POST['new-password']);
															$sql = "SELECT * FROM uzytkownicy WHERE login = '$login';"; //ZAPYTANIE MAJACE NA CELU SPRAWDZENIE CZY PODANY LOGIN JUZ ISTNIEJE W BAZIE
															$query = mysqli_query($connect, $sql);

															$sql2 = "SELECT ID FROM courses_repo ;"; //ZAPYTANIE MAJACE NA CELU ZLICZENIE ILOSCI KURSOW Z BAZY
															$query2 = mysqli_query($connect, $sql2);
							
															if((mysqli_num_rows($query)) == 0){ //JESLI NIE ZNALEZIONO PODANEGO LOGINU TO MOZNA UTWORZYC KONTO

																$password = password_hash($password, PASSWORD_BCRYPT);
																
																$sql = "INSERT INTO uzytkownicy (login,password, type, pass_set_by_user) VALUES ('$login','$password','user','NO');";
																if (mysqli_query($connect, $sql)) {
																	
																	$courses_amount = mysqli_num_rows($query2); 
																	$counter = 1;
																	$sql_id = "SELECT ID FROM uzytkownicy WHERE login = '$login';";
																	$query_id = mysqli_query($connect, $sql_id);
																	$row=$query_id->fetch_assoc();

																	$id = (int) $row['ID'];
										
																	while($counter <= $courses_amount){ //PRZYPISYWANIE KURSOW USEROWI
																		$sql = "INSERT INTO courses_assignments (course_ID,user_ID) VALUES ('$counter','$id');";
																		mysqli_query($connect, $sql);
											
																		if ($counter == 1) //CSRF
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - CSRF without any prevention mechanism implemented','This laboratory contains web application with the simpliest CSRF Vurnelability. To solve this lab change the email of the user.
																			Use the following credentials for victim account: login: franek password: lel123																		
																			','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 2 - CSRF where token validation depends on token being present','This laboratory contains web application with the CSRF Vurnelability. To solve this lab change the email of the user.
																			Use the following credentials for victim account: login: franek password: lel123','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','CSRF lab 3 title','content CSRF 3','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','CSRF lab 4 title','content CSRF 4','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','CSRF lab 5 title','content CSRF 5','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','CSRF lab 6 title','content CSRF 6','NO','$id');";
																			mysqli_query($connect, $sql);

												
																		}
																		else if ($counter == 2) // XSS
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - Reflected XSS without encoding','Laboratory contains the simpliest reflected cross-side scripting vulnerability in the web application. To solve this lab execute simple alert() function.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 2 - Reflected XSS with encoding of most tags and attributes','Laboratory contains the Reflected XSS vulnerability in the web application. Allmost all HTML tags are encoded.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 3 - Reflected XSS with encoding of all HTML tags except custom ones','Laboratory contains the Reflected XSS vulnerability in the web application. All HTML tags are encoded except custom ones. 
																			To solve this lab execute alert() function which displays users cookie.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 4 - Stored XSS without encoding','Laboratory contains the simpliest stored cross-side scripting vulnerability in the web application comment section. To solve this lab execute simple alert() function.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 5 - Stored DOM XSS','This lab demonstrates a stored DOM vulnerability in the blog comment functionality. To solve this lab, exploit this vulnerability to call the alert() function.

																			','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 6 - Reflected XSS with escape from the Javascript string','This lab contains a reflected cross-site scripting vulnerability in the search query. The reflection occurs inside a JavaScript string. To solve this lab, perform a cross-site scripting attack that breaks out of the JavaScript string and calls the alert function.','NO','$id');";
																			mysqli_query($connect, $sql);




																		}
																		else if ($counter == 3) //SQLI
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - SQL injection vulnerability in WHERE clause breach to retrieve hidden data','This lab contains an SQL injection vulnerability in the document filter. To solve the lab, perform an SQL injection attack that causes the application to display details of all documents even these hidden to users.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 2 - SQL injection vulnerability allowing login bypass','This lab contains an SQL injection vulnerability in the login function.To solve the lab, perform an SQL injection attack that logs in to the application as the \"admin\" user.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 3 -  SQL injection UNION attack, retrieving data from other tables','This lab contains an SQL injection vulnerability in the documents filter. The results from the query are returned in the response so you can use a UNION attack to retrieve data from other tables. The database contains a different table called users, with same amount of columns.To solve the lab, perform an SQL injection UNION attack that retrieves all usernames and passwords, and use the information to log in as the admin user.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 4 - Blind SQL injection with time delays','This lab contains a blind SQL injection vulnerability. The application uses a tracking cookie to welcome user, and performs an SQL query containing the value of the submitted cookie. The results of the SQL query are not returned, and the application does not respond any differently based on whether the query returns any rows or causes an error. To solve the lab, exploit the SQL injection vulnerability to cause a 10 second delay.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 5 - SQL injection attack, querying the database type and version on MySQL','This lab contains an SQL injection vulnerability in the documents filter. You can use a UNION attack to retrieve the results from an injected query. To solve the lab, display the database version string.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 6 - SQL injection UNION attack, retrieving multiple values in a single column','This lab contains an SQL injection vulnerability in the documents filter. The results from the query are returned in the response so you can use a UNION attack to retrieve data from other tables. The database contains a different table called users, with columns called login and password. To solve the lab, perform an SQL injection UNION attack that retrieves all usernames and passwords, and use the information to log in as the admin user.','NO','$id');";
																			mysqli_query($connect, $sql);




																		}
																		else if ($counter == 4) //SSRF
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','SSRF lab 1 title','content SSRF 1','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','SSRF lab 2 title','content SSRF 2','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','SSRF lab 3 title','content SSRF 3','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','SSRF lab  4 title','content SSRF 4','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','SSRF lab  5 title','content SSRF 5','NO','$id');";
																			mysqli_query($connect, $sql);


																		}

																		else if ($counter == 5) //BRUTE
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - Username enumeration via different responses','To solve the lab, enumerate a valid username, brute-force this user\'s password, then access their page.','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Brute Force lab 2 title','content Brute Force 2','NO','$id');";
																			mysqli_query($connect, $sql);

																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Brute Force lab 3 title','content Brute Force 3','NO','$id');";
																			mysqli_query($connect, $sql);



																		}
																		else if ($counter == 6) //FI
																		{
												
																			$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','File Inclusion lab 1 title','content File Inclusion 1','NO','$id');";
																			mysqli_query($connect, $sql);



																		}
																		$counter += 1;
																	}

																}
									
																echo'
																<script type="text/javascript">
																	toastr.success("Account \"'.$login.'\" has been created!")
																</script>';

															}else{
															
																echo'
																<script type="text/javascript">
																toastr.warning("login  \"'.$login.'\" is already in use!")
																</script>';
															}
								
															mysqli_close($connect);
														}
													?> 
											
										
											</div>
											<button type="submit" style=" border-radius:0; background-color:#b1de35; margin-top:5%; width:100%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons" name="register"><i class="fas fa-pencil-alt"></i> Load user to Database</button>
										</form>
										
									</div>
								</div>
								
								<script>
								$(".parent1").click(function () {
									if($(".content1").hasClass("show"))
										$(".content1").collapse("hide");
									else
										$(".content1").collapse("show");
								});
								</script>
								
								
								
								
								<div class=" card  border-0" style="margin:0.5%; border-radius:0;">  <!-- BLOKOWANIE KONTA UZYTKOWNIKA -->
									<div class=" parent2 card-header list-group-item-grey border-0 btn button text-left border-dark" id="heading2"  style="border-radius:0 ;margin-bottom:0%; " type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
										
											Block User pernamently
										
										<span class="float-right badge-pill  badge-primary">PRD feature</span>
									</div>

									<div id="collapse2" class="collapse content2 border-0" aria-labelledby="heading2" data-parent="#accordion"  !important" style="background-color:#d1ff52;  background-image: linear-gradient(#868e96 10%, rgba(134,142,150,0.6), #bbe053 );" >
										
										<div class=" text-justify lab_content border-dark" style="font-size:100%; padding:2%;">
										<form method="POST" action="admin_console">
												<div class="row justify-content-center" style="padding:2%;">
													<div style="width:45%; margin-right:5%;">
														<input class="form-control" type="text" placeholder="login" name="login_block" required>
													</div>
													<div style="width:45%;">
														<input class="form-control" type="text" placeholder="reason" name="login_block_r" required>
													</div>
												</div>
												<?php 
													$login_block = "";
													$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
													if(!$connect) echo "Blad polaczenia z baza danych!".'<br>'.mysqli_errno;
													if( isset($_POST['block_user']) && isset($_POST['login_block']) && isset($_POST['login_block_r']) )
													{
														$login_block = $_POST['login_block'];
														$sql = "SELECT * FROM uzytkownicy WHERE login = '".$_POST['login_block']."'; ";
														$query = mysqli_query($connect, $sql);
														if((mysqli_num_rows($query)) != 0){
															$row = mysqli_fetch_array($query);
										
															$login = $row['login']; 
															$id=  $row['ID'];

															$sql = "UPDATE uzytkownicy SET ac_status = 'inactive' WHERE ID = $id ";
															mysqli_query($connect, $sql);

															$sql = "INSERT INTO blocked_users (user_ID, reason) VALUES ($id, '".$_POST['login_block_r']."') ";
															mysqli_query($connect, $sql);
															echo'
															<script type="text/javascript">
															toastr.info("Account \"'.$login_block.'\" has been blocked!")
															</script>';
														}else{
															echo'
															<script type="text/javascript">
															toastr.error("Account \"'.$login_block.'\" doesn\'t exist!")
															</script>';
														}
														
													}
												?>
										</div>

											<button type="submit" style=" border-radius:0; background-color:#b1de35; margin-top:5%; width:100%; border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons" name="block_user"><i class="fas fa-pencil-alt"></i> Block user </button>
										</form>
									</div>
								</div>
								
								<script>
								$(".parent2").click(function () {
									if($(".content2").hasClass("show"))
										$(".content2").collapse("hide");
									else
										$(".content2").collapse("show");
								});
								</script>
								
								
								
								
								<div class=" card  border-0" style="margin:0.5%; border-radius:0;">  <!-- RESETOWANIE PROGRESU USEROWI -->
									<div class=" parent3 card-header list-group-item-grey border-0 btn button text-left border-dark" id="heading3"  style="border-radius:0 ;margin-bottom:0%;" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
										
											Reset User progress
										
										<span class="float-right badge-pill badge-info">DEV feature </span>
									</div>

									<div id="collapse3" class="collapse content3 border-0" aria-labelledby="heading3" data-parent="#accordion"  !important" style="background-color:#d1ff52;  background-image: linear-gradient(#868e96 10%, rgba(134,142,150,0.6), #bbe053 );" >
										
										<div class=" text-justify lab_content border-dark" style="font-size:100%; padding:2%;">
											<form method="POST" action="admin_console">
												<div class="row justify-content-center"  >
													<input  style="width:50%;" class="form-control" type="text" placeholder="login" name="login_reset" required>
												</div>
												<?php
													$login_reset = "";
													
													$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
													if(!$connect) echo "Blad polaczenia z baza danych!".'<br>'.mysqli_errno;

													if(isset($_POST['reset'])){
														
														$login = strip_tags($_POST['login_reset']); 
														$sql_id = "SELECT ID FROM uzytkownicy WHERE login = '$login';";
														$query_id = mysqli_query($connect, $sql_id);
														if((mysqli_num_rows($query_id)) != 0){
															$row=$query_id->fetch_assoc();
															$id = (int) $row['ID'];

															$sql = "UPDATE course_content SET status = 'NO' WHERE user_ID = '$id';";
															$query = mysqli_query($connect, $sql);
															//echo "<p style='margin-top:5%;'>User courses progress cleared successfully!</p>";
															echo'
															<script type="text/javascript">
															toastr.info("'.$login.'\'s courses cleared successfully!")
															</script>';
														}else{
															echo'
															<script type="text/javascript">
															toastr.error("Account \"'.$login.'\" doesn\'t exist!")
															</script>';
														}

													}
												?>
										</div>
										
											<button type="submit" style=" border-radius:0; background-color:#b1de35; margin-top:5%; width:100%; border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons" name="reset"><i class="fas fa-pencil-alt"></i> Reset user progress </button>
										</form>
									</div>
								</div>
								
								<script>
								$(".parent3").click(function () {
									if($(".content3").hasClass("show"))
										$(".content3").collapse("hide");
									else
										$(".content3").collapse("show");
								});
								</script>
								
								
								
								
								
								<div class=" card  border-0" style="margin:0.5%; border-radius:0;">  <!-- USUNIECIE USERA Z DB -->
									<div class=" parent4 card-header list-group-item-grey border-0 btn button text-left border-dark" id="heading4"  style="border-radius:0 ;margin-bottom:0%; " type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
										
											Remove user from Database
										
										<span class="float-right badge-pill badge-info">DEV feature </span>
									</div>

									<div id="collapse4" class="collapse content4 border-0" aria-labelledby="heading4" data-parent="#accordion"  !important" style="background-color:#d1ff52;  background-image: linear-gradient(#868e96 10%, rgba(134,142,150,0.6), #bbe053 );" >
										
										<div class=" text-justify lab_content border-dark" style="font-size:80%; padding:2%;">
											<form method="POST" action="admin_console">
												<div class="row justify-content-center" >
													<input style="width:50%;" class="form-control" type="text" placeholder="login" name="login_remove" required>
												</div>
												<?php
													$login_remove = "";
													$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
													if(!$connect) echo "Blad polaczenia z baza danych!".'<br>'.mysqli_errno;

													if(isset($_POST['remove'])){
														$login_remove = $_POST['login_remove'];
														$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
														$sql = "SELECT * FROM uzytkownicy WHERE login = '".$_POST['login_remove']."'; ";
														$query = mysqli_query($connect, $sql);
														if((mysqli_num_rows($query)) != 0){
															$row = mysqli_fetch_array($query);

															$login = $row['login']; 
															$id=  $row['ID'];


															$sql = "DELETE FROM uzytkownicy where ID = '$id' ";
															mysqli_query($connect, $sql);

															$sql = "DELETE FROM blocked_users WHERE user_ID = '$id' ";
															mysqli_query($connect, $sql);

															$sql = "DELETE FROM courses_assignments WHERE user_ID = '$id' ";
															mysqli_query($connect, $sql);

															$sql = "DELETE FROM course_content WHERE user_ID = '$id' ";
															mysqli_query($connect, $sql);


												

															echo'
															<script type="text/javascript">
															toastr.info("Account \"'.$login.'\" has been removed !")
															</script>';
														}else{
															echo'
															<script type="text/javascript">
															toastr.error("Account \"'.$login_remove.'\" doesn\'t exist !")
															</script>';
														}
														

													}
												?>
										</div>
										
											<button type="submit" style=" border-radius:0; background-color:#b1de35; width:100%; margin-top:5%; border: 1px  solid #8aad28; color:757575;"  class="btn button form_buttons" name="remove"><i  class="fas fa-pencil-alt"></i> Remove user pernamently </button>
										</form>
									</div>
								</div>
								
								<script>
								$(".parent4").click(function () {
									if($(".content4").hasClass("show"))
										$(".content4").collapse("hide");
									else
										$(".content4").collapse("show");
								});
								</script>


								

							</div>
						<div>
					
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