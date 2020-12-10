
<script type="text/javascript">  
(function() {
    var _alert = window.alert;                   // <-- Reference
    window.alert = function(str) {
		var labcore = document.getElementById("labcore");
		document.getElementById('commit').click();

        // do something additional
        if(console) console.log(str);
        //return _alert.apply(this, arguments);  // <-- The universal method
        _alert(str);                           // Suits for this case
    };
})();;  
  
</script>  
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>
<div class="col-sm-12 " id="labcore" style="border-radius:10px; height:100% !important; background: rgba(134,142,150,0.6);">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%;">XSS LAB 6</h4></div>
	<div class="row" style="height:500px !important; padding:3%;">
		<div class="col-4">

			<div class="card bg-dark" > 
				<div class="card-body " style="padding-bottom:10%; padding-top:5%;">

				<h4 id="box1" style="color:#b1de35;">Hello! What are you looking for? </h4> <!-- FORMULARZ LOGOWANIA -->
					<div class="row">
						
						<form method="POST" action="/lab">
							<div style="margin-bottom:5%; margin-top:5%;">
								<input class="form-control" placeholder="search" type="text" name="nick" required>
							</div>
							<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="sub"><i class='fas fa-sign-in-alt'></i> Search </button>
						</form>
					</div>
				</div>
			</div>
			<?php
			if(isset($_POST["sub"]) AND isset($_POST['nick']))
			{
				$nick = $_POST['nick'];
				$nick = str_replace("<","&lt;",$nick);
				$nick = str_replace(">","&gt;",$nick);

				echo'
						<div class="card bg-dark " style="margin-bottom:7%; margin-top:10%;  "> 
							<div class="card-body " style="padding-bottom:10%; padding-top:5%;">
								<h4 id="result" style="color:#b1de35;"><span id="result1"></span></h4>
							</div>
						</div>

					';

				}
			?>
			<script>
				var str = '<?php echo $nick ?>';
				document.getElementById("result1").innerHTML = str;
			</script>

		</div>

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
						$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 2 AND course_content.title = 'Lab 6 - Reflected XSS with escape from the Javascript string') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
						mysqli_query($connect, $sql);
						//$_SESSION['lab'] = "/lab";
						//$_SESSION['lab_switch'] = 0;
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
