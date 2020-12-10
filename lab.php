<?php
	session_start();
	if(!isset($_SESSION['login']) or ($_SESSION['type'] != "user")){
            header('Location:dashboard');
		    exit();
	}
    elseif($_SESSION['type'] == "user"){
        if($_SESSION['userpass'] == "NO")
        {
             header('Location:index_');  
             exit();
		}
    }
?>

<!DOCTYPE html>
<?php
	error_reporting(0);
	ini_set('display_errors', 0);
	if( ($_SESSION["lab"] == "Labs\sql_lab\sql4.php") && (!isset($_COOKIE['trackingID'])) && ($_SESSION['sqli'] == "logged") ){ // DO SQL4 - SPROBOWAC PRZENIESC DO LABA

		$server='localhost';
		$user='root';
		$password='P@rtyboy1.';
		$baza='labdb_sql';
		$connect = mysqli_connect($server, $user, $password, $baza);
		$login = $_SESSION['sqlilogin'];
		

		$cookie_name = "trackingID";
		$cookie_value = md5($login);
		setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/"); // 86400 = 1 day	
		

	}

?>
<html>
	<head>
		<title>Laboratory</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link rel="stylesheet" href="/styles/style.css">
		<style>
		.nav-item{margin-left:3%;}
		
		</style>
		
	</head>
		
	<body class="" style="background-image: url('img/bg_test.png'); background-repeat: auto; background-size: 1920px 1080px;">

<!--
		Button to Open the Modal 
		<button type="button" id="ModalButton" class="btn btn-primary d-none" data-toggle="modal" data-target="#myModal"></button>
		
		 The Modal 
		<div class="modal fade " id="myModal"  data-keyboard="false" data-backdrop="static" style="margin:auto; margin-top:18%; width:50%; ">
			<div class="modal-dialog modal-lg" >
				<div class="modal-content border-dark" style="background: rgba(134,142,150,0.6);">

					 Modal Header 
					<div class="modal-body" style="margin:auto;">
						<h4 class="modal-title" style="margin:auto; color: #d1ff52;">Congratulation! You have just completed the laboratory!</h4>	
					</div>
					 Modal footer 
					
					<button type="button" onclick="refreshPage();"  style=" border-radius:0;width:100%; background-color:#b1de35;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons" data-dismiss="modal">Got it</button>
					<script>
						function refreshPage(){
							
							//Place as last thing before the closing </body> tag
							if(location.search.indexOf('r') < 0){
							var hash = window.location.hash;
							var loc = window.location.href.replace(hash, '');
							loc += (loc.indexOf('?') < 0? '?' : '&') + 'r';
							// SET THE ONE TIME AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS):
							setTimeout(function(){window.location.href = loc + hash;}, 1);
							}
							
						}				
					</script>
				</div>
			</div>
		</div>
		-->


		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("nav.php"); ?>
				</div>
				
				<div class="col-sm-9" style="">
					<div class="row justify-content-center">
						<h3 style="color: #d1ff52;  margin-top:1%; margin-bottom:2%;">Laboratory</h3>
					</div>
					<div class="container-fluid" style="height:100%;">
						<?php 


							
							if(isset($_POST["giveup"])) // JESLI UZYTKOWNIK PRZERWIE LAB TO ZMIENIANE SA ODPOWIEDNIE ZMIENNE SESJI ORAZ WYKONYWANY JEST REFRESH STRONY
							{

								$_SESSION['lab'] = "lab";
								$_SESSION['lab_switch'] = 0;
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
									$server='localhost';
									$user='root';
									$password='P@rtyboy1.';
									$baza='labdb_xss';
									$connect = mysqli_connect($server, $user, $password, $baza);
									$sql = "DELETE FROM comments;";
									mysqli_query($connect, $sql);
									
							}

							if($_SESSION['lab'] != 'lab'){
								$lab = $_SESSION['lab'];
								require_once("$lab"); 
								
							}

							if(isset($_COOKIE['trackingID']) && ($_SESSION["lab"] == "Labs\sql_lab\sql4.php")) // DO LABA SQL4 SPROBOWAC PRZENIESC DO SQL4.PHP
							{
								$cookie_value = $_COOKIE['trackingID'];
								if ( (strpos($cookie_value, 'sleep') != false) OR (strpos($cookie_value, 'SLEEP') != false) OR (strpos($cookie_value, 'Sleep') != false))
								{

									function get_string_between($string, $start, $end){
										
										$ini = strpos($string, $start);
										if ($ini == 0) return '';
										$ini += strlen($start);
										$len = strpos($string, $end, $ini) - $ini;
										return substr($string, $ini, $len);
									}
									
									$fullstring = $cookie_value;
									$parsed = get_string_between($fullstring, '(', ')');
									$parsed3 = (int)($parsed / 3);
									
									if (strpos($cookie_value, 'sleep') != false){ $cookie_value = str_replace("sleep($parsed)","sleep($parsed3)",$cookie_value);}
									elseif (strpos($cookie_value, 'SLEEP') != false){ $cookie_value = str_replace("SLEEP($parsed)","SLEEP($parsed3)",$cookie_value);} 
									elseif (strpos($cookie_value, 'Sleep') != false){ $cookie_value = str_replace("Sleep($parsed)","Sleep($parsed3)",$cookie_value);}
								}

								$server='localhost';
								$user='root';
								$password='P@rtyboy1.';
								$baza='labdb_sql';
								$connect = mysqli_connect($server, $user, $password, $baza);
								$sql = "SELECT visitID FROM visits WHERE visitID = '$cookie_value'";
								

								$result = $connect->query($sql);
								while($row = mysqli_fetch_array($result)) {
									$already_visited = $row['visitID']; 
												
								}

								if( ($already_visited != $cookie_value) )
								{
									$cookie_value = $_COOKIE['trackingID'];
									$server='localhost';
									$user='root';
									$password='P@rtyboy1.';
									$baza='labdb_sql';
									$connect = mysqli_connect($server, $user, $password, $baza);
									$sql = "INSERT INTO visits (visitID) VALUES ('$cookie_value')";
									mysqli_query($connect, $sql);
								
								}


							}
							//echo "<p style='color:white;'>".(microtime(true) -  $_SERVER['REQUEST_TIME_FLOAT'])."</p>";
							//echo $cookie_value;
							$_SESSION['sqlitime'] = (microtime(true) -  $_SERVER['REQUEST_TIME_FLOAT']);
							$precise_time = (microtime(true) -  $_SERVER['REQUEST_TIME_FLOAT']);
						
							if( (($_SESSION['sqlitime'] <= 10) AND ($_SESSION['sqlitime'] > 9)) && ($_SESSION["lab"] == "Labs\sql_lab\sql4.php")){
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
								$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 3 AND course_content.title = 'Lab 4 - Blind SQL injection with time delays') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
								mysqli_query($connect, $sql);
								//$_SESSION['lab'] = "/lab";
								//$_SESSION['lab_switch'] = 0;
								//echo'
								//<script>
								//	setTimeout(function(){ document.getElementById("ModalButton").click();; }, 1000);
								//</script>';
								echo'
								<script type="text/javascript">			
									setTimeout(function(){ toastr.success("Congratulation! You have just completed the laboratory! It took '.$precise_time.' seconds to get response.");; }, 1000);
								</script>';
							}
						?>
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