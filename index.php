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
    
<body class="" style="background-image: url('img/bg_test.png');background-repeat: auto; background-size: 1920px 1080px;">

	<div class="container-fluid"> 
		<div class="col-sm-2" style="margin:auto; margin-top:15%;">
			<h4 style="color:#b1de35;">Sign in Panel</h4> <!-- FORMULARZ LOGOWANIA -->
			<form method="POST" action="session">
				<div style="margin-bottom:5%; margin-top:5%;">
					<input class="form-control" placeholder="Login" type="text" name="login" required>
				</div>
				<div  style="margin-bottom:5%; margin-top:5%;">
					<input class="form-control " placeholder="Password" type="password" name="pass" required>
				</div>

			
			
				<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="log"><i class='fas fa-sign-in-alt'></i> Sign in </button>	
			</form>

			<button type="submit" data-toggle="collapse" data-target="#collapseReg" aria-expanded="false" aria-controls="collapseReg" style=" background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%; " class="btn button form_buttons  float-left" name="reg_form"><i class='fas fa-seedling'></i> Sign up</button>


		

		
		</div>

	</div><br><br>
			<?php
				
				session_start();
				
				if(isset($_SESSION['login']) && ($_SESSION['pass'] == true)){ 
					if($_SESSION['acstatus'] == 'active'){ //JESLI ZOSTANIE NAWIAZANA SESJA DLA PODANEGO USERA
						if($_SESSION['userpass'] == 'YES') //JESLI USER NIE MUSI ZMIENIAC DOMYSLNEGO HASLA
						{
							header('Location:home'); //TO ZALOGUJ NA STRONE DOMOWA HOME
							exit();
						}
						elseif($_SESSION['userpass'] == 'NO') // W PRZECIWNYM RAZIE...
						{
							
							header('Location:index_'); //PRZENIES NA STRONE GDZIE USER MUSI USTAWIC NOWE HASLO
						}
					
					}
					
				}
				
 
				$connect = mysqli_connect ('localhost', 'root', 'P@rtyboy1.','labdatabase');
				if(!$connect) echo "Blad polaczenia z baza danych!".'<br>'.mysqli_errno;
				
				if( ( isset($_POST['register']) && isset($_POST['login_reg']) && isset($_POST['pass_reg']) && isset($_POST['pass_conf']) )  && ($_POST['pass_reg'] == $_POST['pass_conf']) ){ //DODAWANIE USERA DO BAZY WRAZ Z PRZYPISANIEM MU WSZYSTKICH KURSOW JAKIE SĄ W PLATFORMIE
						
					$login = strip_tags($_POST['login_reg']); 
					$password =  strip_tags($_POST['pass_reg']);
					$sql = "SELECT * FROM uzytkownicy WHERE login = '$login';";
					$query = mysqli_query($connect, $sql);
					
					$sql2 = "SELECT ID FROM courses_repo ;"; //ZAPYTAIE MAJACE NA CELU ZLICZENIE ILOSCI KURSOW Z BAZY
					$query2 = mysqli_query($connect, $sql2);

					if((mysqli_num_rows($query)) == 0){
						$created = "NO";
						$password = password_hash($password, PASSWORD_BCRYPT);
						$sql = "INSERT INTO uzytkownicy (login,password, pass_set_by_user) VALUES ('$login','$password','YES');";
						if (mysqli_query($connect, $sql)) {
							$courses_amount =  mysqli_num_rows($query2);
							$counter = 1;
							$sql_id = "SELECT ID FROM uzytkownicy WHERE login = '$login';";
							$query_id = mysqli_query($connect, $sql_id);
							$row=$query_id->fetch_assoc();

							$id = (int) $row['ID'];
							
							while($counter <= $courses_amount){
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
									
									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - Reflected XSS without encoding','Laboratory contains the simpliest cross-side scripting vulnerability in the web application. To solve this lab execute simple alert() function.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 2 - Reflected XSS with encoding of most tags and attributes','Laboratory contains the Reflected XSS vulnerability in the web application. Allmost all HTML tags are encoded.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 3 - Reflected XSS with encoding of all HTML tags except custom ones','Laboratory contains the Reflected XSS vulnerability in the web application. All HTML tags are encoded except custom ones. To solve this lab execute alert() function which displays users cookie.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 4 - Stored XSS without encoding','Laboratory contains the simpliest stored cross-side scripting vulnerability in the web application comment section. To solve this lab execute simple alert() function.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 5 - Stored DOM XSS','This lab demonstrates a stored DOM vulnerability in the blog comment functionality. To solve this lab, exploit this vulnerability to call the alert() function.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 6 - Reflected XSS with escape from the Javascript string','This lab contains a reflected cross-site scripting vulnerability in the search query. The reflection occurs inside a JavaScript string. To solve this lab, perform a cross-site scripting attack that breaks out of the JavaScript string and calls the alert function.','NO','$id');";
									mysqli_query($connect, $sql);



								
								}
								else if ($counter == 3) //SQLI
								{
									
									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - SQL injection vulnerability in WHERE clause breach to retrieve hidden data','This lab contains an SQL injection vulnerability in the document filter. To solve the lab, perform an SQL injection attack that causes the application to display details of all documents even these hidden to users.','NO','$id');";
									mysqli_query($connect, $sql);

									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 2 - SQL injection vulnerability allowing login bypass','This lab contains an SQL injection vulnerability in the login function. To solve the lab, perform an SQL injection attack that logs in to the application as the \"admin\" user.','NO','$id');";
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
									
									$sql = "INSERT INTO course_content (course_ID,title,content, status, user_ID ) VALUES ('$counter','Lab 1 - Username enumeration via different responses','To solve the lab, enumerate a valid username, brute-force this user\'s password, then access their account page.','NO','$id');";
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
							unset($_SESSION['error']);
							$created = "YES";
							//echo "<div class='container-fluid col-sm-2'><p class='text-warning'>Account has been created</p> </div>
							echo"
							<script>
								toastr.success('Your account has been successfully created !')
							</script>	
							";
							
						} else {
							
							//echo "Error: " . $sql . "<br>" . mysqli_error($connect);
						}
						
					}else{
						$_SESSION['error'] = "<p class='text-warning'>This login name is already in use</p>";
						echo"
						<script>
							toastr.warning('login  \"$login\" is already in use')
						</script>";
						//echo'<div class="container-fluid col-sm-2"> '.$_SESSION['error'].' </div> ';

						
					}
							
					mysqli_close($connect);
				}elseif( isset($_POST['pass_reg']) && isset($_POST['pass_conf']) && ($_POST['pass_reg'] != $_POST['pass_conf'])){
					$_SESSION['error'] = "<p class='text-warning'>Provided passwords are different</p>";
					echo"
					<script>
						toastr.warning('Provided passwords are different');
					</script>";
				}
				if(isset($_SESSION['error']))
				{
					$error =  $_SESSION['error'];
					//echo'<div class="container-fluid col-sm-2"> '.$_SESSION['error'].' </div> ';
					echo"<script>
					toastr.error('$error');
					</script>";
					
				}
			?> 
	<div class="collapse container-fluid col-sm-2" id="collapseReg" style="margin:auto; margin-top:1%;"> <!-- FORMULARZ REJESTRACYJNY -->
		<div class="card card-body" style="background: rgba(134,142,150,0.6) !important;">
			<form method="POST" action="index">
				<div style="margin-bottom:5%; margin-top:5%;">
					<input class="form-control" placeholder="Input Login" type="text" name="login_reg" required>
				</div>
				<div style="margin-bottom:5%; margin-top:5%;">
					<input class="form-control " placeholder="Input Password" type="password" name="pass_reg" required>
				</div>
				<div>
					<input class="form-control " placeholder="confirm password" type="password" name="pass_conf" required>
				</div><br>
			
			
				<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="register"><i class='fas fa-pencil-alt'></i> Submit </button>
			</form>
		</div>
	</div>

	


	<div class="fixed-bottom container-fluid" style="margin:auto;">
		<?php 
		    require_once("footer.php"); 
		?>
	</div>
</body>


</html>