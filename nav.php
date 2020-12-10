	<link rel="stylesheet" href="/styles/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="/styles/font-awesome.min.css">
	<link rel="stylesheet" href="/styles/style.css">


	<script src="/scripts/a076d05399.js"></script>
	<script src="/scripts/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="/scripts/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="/scripts/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


	<div class="col-sm-12 border-0" style="margin-top:-20%;">
		<div class="my-bg border-0">


			<div class="list-group" style='background: rgba(177, 222, 53,1) !important; '>

				<?php  
					
					$server='localhost';
					$user='root';
					$password='P@rtyboy1.';
					$baza='labdatabase';
					$connect = mysqli_connect($server, $user, $password, $baza);
						
					$sql = "SELECT ID, type from uzytkownicy WHERE login = '".$_SESSION['login']."'"; //WYCIĄGNIJ ID, TYP KONTA USERA W CELU WYKORZYSTANIA W KOLEJNYCH ZAPYTANIACH
					$result = $connect->query($sql);
					while($row = mysqli_fetch_array($result)) {
						$id= $row['ID']; 
						$type = $row['type'];
					}

					echo"<h6 style='margin:auto; margin-top:27%; margin-bottom: 5% ; ' class='text-center '>Signed as: ".$_SESSION['login']."</h6>";  
					if($_SESSION['type'] == "admin") //IF SIGNED AS ADMIN DISPLAYS ADMIN NAVBAR 
					{
						echo"<a href='/dashboard' class='list-group-item button buttonnav text-left'> <i class='fas fa-tachometer-alt'></i> dashboard</a>";
						echo"<a href='/admin_console' class='list-group-item button buttonnav text-left ' ><i class='fas fa-user-secret'></i> User Management</a>";
						echo"<a href='/setup' class='list-group-item  button buttonnav text-left'><i class='fas fa-cogs '></i> Setup</a>";
						echo"<a href='/logout' class='list-group-item  button buttonnav text-left'><i class='fas fa-sign-out-alt'></i> Sign out</a>";
					}
					elseif($_SESSION['type'] == "user") // IN OTHER WAY DISPLAYS USER NAVBAR
					{
						echo"<a href='/home' class='list-group-item   button  text-left '><i class='fas fa-heartbeat'></i> User dashboard </a>";
						echo"<a href='/settings' class='list-group-item   button  text-left'> <i class='fas fa-cog '></i> Settings</a>";
						echo"<a href='/file_upload' class='list-group-item  button text-left'> <i class='fas fa-upload'></i> File upload</a>";
						if(strpos($_SESSION["lab"] , 'csrf') !== false) 
							echo"<a href='/exploitloader' class='list-group-item button  text-left'> <i class='fas fa-bug	'></i> Exploit Charger</a>";
						if($_SESSION['lab'] != "lab") // JESLI USER LADUJE LABORATORIUM TO...
						{
							if($_SESSION['lab_switch'] == 0) //TO PRZEJDZIE ANIMACJA WYPELNIANIA SIE BATERII
							{
								echo"<div class='labnaver' ><a href='/lab' class='list-group-item button text-left labnaver'> <i id='labnaver' class='fa '></i> Charged Laboratory Core</a></div>
									<script>
									function chargebattery() {
									var a;
									a = document.getElementById('labnaver');
									a.innerHTML = '&#xf244;';
									setTimeout(function () {
									a.innerHTML = '&#xf243;';
									}, 1000);
									setTimeout(function () {
									a.innerHTML = '&#xf242;';
									}, 1300);
									setTimeout(function () {
									a.innerHTML = '&#xf241;';
									},1600);
									setTimeout(function () {
									a.innerHTML = '&#xf240;';
									}, 1900);
									}
									chargebattery();
									</script>";
								$_SESSION['lab_switch'] = 1; //ZMIENNA SESJI SIE ZAKTUALIZUJE
			
							}
							else //JESLI LABORATORIUM JEST JUZ ZALADOWANE TO GENERUJE PELNA BATERIE W NAVBAR
							{	
								echo"<div class='labnaver'><a href='/lab' class='list-group-item  button text-left labnaver'> <i id='labnaver' class='fas fa-battery-full'></i> Charged Laboratory Core </a></div>";
								
							}
						}	 
						else //JESLI NIE MA ZADNEGO LABA TO BATERIA JEST PUSTA 
						{
						echo"<a href='/lab' class='list-group-item  button text-left'> <i id='emptylab' class='fas fa-battery-empty'></i> Empty Laboratory Core</a>";
						}
						
						echo"<a href='/logout' class='list-group-item  button text-left'><i class='fas fa-sign-out-alt'></i> Sign out </a>";
						echo"<h6 class='text-center' style='margin:auto; margin-top:5%; margin-bottom: 5%; '>Penetration tests courses</h6>";
					
						

					$sql = "Select uzytkownicy.login,   courses_repo.Name, courses_repo.Topics_amount, courses_repo.page, count(course_content.status) as status from courses_assignments
					                JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
					                JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
                                    JOIN course_content on course_content.course_ID = courses_assignments.course_ID
									
					                WHERE (courses_assignments.user_ID = course_content.user_ID) and status = 'yes' and login = '".$_SESSION['login']."' GROUP BY courses_assignments.course_ID";
					$result = $connect->query($sql);
					while($row = mysqli_fetch_array($result)) {
						$finished = $row['status']; // UKOŃCZONE KURSY
						$amount =  $row['Topics_amount']; // LICZBA KURSÓW
						$course = $row['Name'];  // NAZWA KURSU
						$page = $row['page']; //NAZWA STRONY KURSU


						if($finished == 0) //W ZALEZNOSCI OD PROGRESU W KURSACH USTAWIA ODPOWIEDNI BADGE OBOK NAZWY KURSU
						{
							echo"<a href='/courses/$page' class='list-group-item button text-left' >$course<span href='$page' class='badge-pill badge-secondary float-right'>New</span></a>"; 
						}
						elseif($finished == $amount) // PROGRESS = 100%
						{
							echo"<a href='/courses/$page' class='list-group-item button text-left '>$course<span href='$page' class='badge-pill badge-dark float-right'>Master</span></a>";
						}
						elseif(floatval($finished) <= floatval(($amount / 3))) //PROGRESS <50%
						{
							echo"<a href='/courses/$page' class='list-group-item  button text-left '>$course<span href='$page' class='badge-pill badge-success float-right'>Newbie</span></a>";
						}
						elseif((floatval($finished) > floatval(($amount / 3))) and  ($finished < ($amount - (floatval(($amount / 2))/2)))) //PROGRESS 50-75%
						{
							echo"<a href='/courses/$page' class='list-group-item  button text-left '>$course<span href='$page' class='badge-pill badge-primary float-right'>Familiar</span></a>";
						}
						elseif($finished >= ($amount - (floatval(($amount / 2))/2))) // PROGRESS > 75%
						{
							echo"<a href='/courses/$page' class='list-group-item button  text-left '>$course<span href='$page' class='badge-pill badge-danger float-right'>Expert</span></a>";
						}

								
					}
					$sql = "Select uzytkownicy.login,   courses_repo.Name, courses_repo.Topics_amount, courses_repo.page, count(course_content.status) as status from courses_assignments
					                JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
					                JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
                                    JOIN course_content on course_content.course_ID = courses_assignments.course_ID
					                WHERE  (courses_assignments.user_ID = course_content.user_ID) and status = 'NO' and login = '".$_SESSION['login']."' GROUP BY courses_assignments.course_ID";
					$result = $connect->query($sql);
					while($row = mysqli_fetch_array($result)) {
						$finished = $row['status']; // UKOŃCZONE KURSY
						$amount =  $row['Topics_amount']; // LICZBA KURSÓW
						$course = $row['Name'];  // NAZWA KURSU
						$page = $row['page']; //NAZWA STRONY KURSU

						if($finished == $amount){
							echo"<a href='/courses/$page' class='list-group-item button  text-left'>$course<span href='$page' class='badge-pill badge-secondary float-right'>New</span></a>"; 
						}
								
					}
				}

				?>	

			</div>
		</div>
	</div>