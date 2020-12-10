<!DOCTYPE html>
<?php
$server='localhost';
$user='root';
$password='P@rtyboy1.';
$baza='labdatabase';

session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['pass']))){
		header('Location:index');
		exit();
	}
	$connect = mysqli_connect($server, $user, $password, $baza);
	
	if(mysqli_connect_errno($connect)){
		echo "There were some issues during performing connections to data base". mysqli_error($connect);
	}else{

	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$hash ="";
	
	$acstatus = "";
	$userpass = "NO";

	$sql = "SELECT * FROM uzytkownicy WHERE login = '$login';";
	$result = $connect->query($sql);
	while($row = mysqli_fetch_array($result)) {
		$hash= $row['password']; 
		$type = $row['type'];
		$pass_set_by_user = $row['pass_set_by_user'];
		$acstatus = $row['ac_status'];
		
	}
	
	$lab = "lab";
	
	$lab_switch = 0;
	
	$error = "";

	$csrf ="";
	$csrflogin ="";
	$exploit_delivered = "NO";
	$csrf_email = "franek@email.com";

	$sqli ="";
	$sqlilogin ="";
	$sqlitime = 0;

	
	
    //$query = mysqli_query($connect,"SELECT * FROM uzytkownicy WHERE login = '$login' AND password = '$pass'");
    if(password_verify($pass, $hash)){
		$_SESSION['lab'] = "lab"; //ZMIENNA ZAWIERA INFORMACJE O TYM CZY USER ZALADOWAL JAKIES LABORATORIUM
		$_SESSION['lab_switch'] = 0; // PRZELACZNIK DO LABOW
		$_SESSION['pass'] = true;//password_verify($_POST['pass'], $pass); 
		$_SESSION['login'] = $login;
		$_SESSION['type'] = $type;
		$_SESSION['userpass'] = $pass_set_by_user; //ZAWIERA INFO CZY USER MA DOMYSLNE HASLO CZY SWOJE (WAZNE W PRZYPADKU KONT ZALOZONYCH PRZEZ ADMINA )
		$_SESSION['acstatus'] = $acstatus;

		$_SESSION['csrf'] = "NO";
		$_SESSION['csrflogin'] = "";
		$_SESSION['exploit_delivered'] = "NO";
		$_SESSION['csrf_email'] = "franek@email.com";

		$_SESSION['sqli'] = "NO";
		$_SESSION['sqlilogin'] = "";
		$_SESSION['sqlitime'] = 0;

        unset($_SESSION['error']);
		//mysqli_free_result($query);
		if($_SESSION['acstatus'] == "inactive")
		{
			$_SESSION['error'] = 'Account: '.$login.' has been blocked';
			header('Location:index');
		}else
		{
			header('Location: index');
		}
	}
	else
	{
		$_SESSION['error'] = 'Wrong login or password';
		header('Location:index');
	}

	
mysqli_close($connect);
}
?>