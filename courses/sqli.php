<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['login']) or ($_SESSION['type'] != "user")){ //ZAPOBIEGANIE WEJSCU ADMINOWI
            header('Location:dashboard');
		    exit();
	}
    elseif($_SESSION['type'] == "user"){ //ZAPOBIEGANIE WEJSCU OSOBIE BEZ ZMIENIONEGO HASLA DOMYSLNEGO W PRZYPADKU KONT UTWORZONYCH PRZEZ ADMINA
        if($_SESSION['userpass'] == "NO")
        {
             header('Location:index_');  
             exit();
		}
    }
?>
<html>
	<head>
		<title>SQLI</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	

		<style>
		.nav-item{margin-left:3%;}
		
		</style>
	</head>
		
	<body class="" style="background-image: url('/img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("../nav.php"); ?>
				</div>
				
				<div class="col-sm-6">

					<div class="container">
						<div class="card border-0" style="margin-bottom:0%; margin-top:3%; !important; background: rgba(134,142,150,0.6);"> <!-- LABORATORY CONTENT -->
							<div class="card-body">
								<div class="row" >
									<h4 class="text-light" style="margin:auto;">Lab Cores repository</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="list-group" >
							<div class="accordion" id="accordion" style="margin-top:1%;">


									<!-- __________________________________________LABORATORY MODULES __________________________________________-->		
								<?php
									$server='localhost';
									$user='root';
									$password='P@rtyboy1.';
									$baza='labdatabase';
									$connect = mysqli_connect($server, $user, $password, $baza);
									$sql = "Select uzytkownicy.login,courses_repo.Name, courses_repo.Topics_amount, course_content.title, course_content.content, course_content.status from courses_assignments
											JOIN uzytkownicy on uzytkownicy.ID = courses_assignments.user_ID
											JOIN courses_repo on courses_repo.ID = courses_assignments.course_ID
											JOIN course_content on courses_repo.ID = course_content.course_ID
											WHERE  (courses_assignments.user_ID = course_content.user_ID) and login = '".$_SESSION['login']."'";
							
									
									$result = $connect->query($sql);
									$counter = 0;
									while($row = mysqli_fetch_array($result)) 
									{
									
										$amount =  $row['Topics_amount'];
										$course = $row['Name'];
										$course_title = $row['title'];
										$content = $row['content'];
										$content_finished_status = $row['status'];
										$counter += 1;


										if($content_finished_status == "NO")
										{	
											$button_value = "not completed";
											$button_color ="danger";
										}
										else
										{
											$button_value = "completed";
											$button_color ="success";
										}

										if($course == "SQL Injection") //WYCIAGNIJ KURS CSRF I DLA KAZDEGO TEMATU WYGENERUJ DANE
										{
											echo'
											<div class=" card  border-0" style="margin-bottom:0.8%; border-radius:0;"> 
												<div class=" parent'.$counter.' card-header list-group-item-grey border-0 text-left border-dark" id="heading'.$counter.'"  style="border-radius:0 ;margin-bottom:0%; background-color:#bbe053;" type="button" data-toggle="collapse" data-target="#collapse'.$counter.'" aria-expanded="false" aria-controls="collapse'.$counter.'">
													
														'.$course_title.'
													
													<span class="float-right badge-pill badge-'.$button_color.'">'.$button_value.'</span>
												</div>

												<div id="collapse'.$counter.'" class="collapse content'.$counter.' border-0" aria-labelledby="heading'.$counter.'" data-parent="#accordion"  !important" style="background-color:#d1ff52;  background-image: linear-gradient(#868e96 10%, rgba(134,142,150,0.6), #bbe053 );" >
													<h6 style="padding:2%;">Lab description</h6>
													<div class=" text-justify lab_content border-dark" style="font-size:80%; padding:2%;">
														'.$content.'
													</div>
													<form method="POST" action="">
														<button type="submit" style=" border-radius:0; background-color:#b1de35; width:100%; margin-top:5%; border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons" name="load'.$counter.'"><i class="fas fa-bolt"></i> Click here to charge Laboratory Core </button>
													</form>
												</div>
											</div>
											
											<script>
											$(".parent'.$counter.'").click(function () {
												if($(".content'.$counter.'").hasClass("show"))
													$(".content'.$counter.'").collapse("hide");
												else
													$(".content'.$counter.'").collapse("show");
											});

											
											</script>
											';
										
										}
									}

									if(isset($_POST["load13"])){ 
										$_SESSION["lab"] = "Labs\sql_lab\sql1.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";
									}
									
									if(isset($_POST["load14"])) {
										$_SESSION["lab"] = "Labs\sql_lab\sql2.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";

									}
									if(isset($_POST["load15"])) {
										$_SESSION["lab"] = "Labs\sql_lab\sql3.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";
	
									}
									if(isset($_POST["load16"])) {
										$_SESSION["lab"] = "Labs\sql_lab\sql4.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";
			
									}
									if(isset($_POST["load17"])) {
										$_SESSION["lab"] = "Labs\sql_lab\sql5.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";
									}
									if(isset($_POST["load18"])) {
										$_SESSION["lab"] = "Labs\sql_lab\sql6.php";
										$_SESSION['sqli'] = "NO";
										$_SESSION['sqlilogin'] = "";
									}


									if(isset($_POST["load18"]) OR isset($_POST["load13"]) OR isset($_POST["load14"]) OR isset($_POST["load15"]) OR isset($_POST["load16"]) OR isset($_POST["load17"]) )
									{
										if(isset($_SESSION["lab_switch"]) == 1) $_SESSION["lab_switch"] = 0; // JEDNORAZOWY REFRESH WYBRANEGO LABORATORIUM
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
								


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="fixed-bottom container-fluid" style="margin:auto;">
            <?php 
                require_once("../footer.php"); 
            ?>
        </div>
	</body>

</html>