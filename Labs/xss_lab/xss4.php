  <form  method="POST" action="/lab">
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:2%;  margin-bottom:0%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>
<div class="col-sm-12" id="labcore" style="border-radius:10px;  background: rgba(134,142,150,0.6);">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; opacity:1;">XSS LAB 4 </h4></div>
	<div class="container-fluid" style=" padding-left:2%;">
	</div>
	<div class="row" style=" padding:2%; height:100%;">
		<div class="col-4">


			<div class="card bg-dark " > 
				<div class="card-body " style="padding-bottom:10%; padding-top:5%;">

					<h6 style="color: #d1ff52;">Post comment</h6>
						<form method="POST" action="/lab">
							<div style="margin-bottom:5%; margin-top:5%;">
								<input class="form-control" placeholder="comment" type="text" name="comment" required>
							</div>
							<button type="submit" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-left:2%;" class="btn button form_buttons float-left" name="com"><i class='fas fa-sign-in-alt'></i> Submit </button>
						</form>

						<?php
						if(isset($_POST["com"]) AND isset($_POST["comment"])){
							$server='localhost';
							$user='root';
							$password='P@rtyboy1.';
							$baza='labdb_xss';
							$connect = mysqli_connect($server, $user, $password, $baza);
							if(!$connect) echo "Can't connect to database!".'<br>'.mysqli_errno;
							$name = $_SESSION['login'];
							$subject = $_POST['comment'];
						
							$sql = "INSERT INTO comments (name, subject) VALUES ('$name', '$subject');";
							$ires = mysqli_query($connect, $sql) or die(mysqli_error($connect));;
							if($ires){
								$smsg = "Your Comment Submitted Successfully";
							}else{
								$fmsg = "Failed to Submit Your Comment";
							}
							
							echo"<script type='text/javascript'>  
							(function() {
								var _alert = window.alert;                   // <-- Reference
								window.alert = function(str) {
									var labcore = document.getElementById('labcore');
									document.getElementById('commit').click();
							
									// do something additional
									if(console) console.log(str);
									//return _alert.apply(this, arguments);  // <-- The universal method
									//_alert(str);                            // Suits for this case
								};
							})();;  
							  
							</script> ";

						}
						

							
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
								$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 2 AND course_content.title = 'Lab 4 - Stored XSS without encoding') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
								mysqli_query($connect, $sql);
								//$_SESSION['lab'] = "/lab";
								//$_SESSION['lab_switch'] = 0;
								//echo'
								//<script>
									//setTimeout(function(){labcore.classList.add("d-none");; }, 1000); 
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
		</div>

		<div class="col-8 " style="height:100%; ">
		
			<div class="card bg-dark  " style=" overflow: auto; height:500px; margin-bottom:%; display:block;"> 
				<div class="card-body " style="padding-bottom:10%; padding-top:5%;">
					<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-bottom:2%;">Comment section</h4></div>
					<?php
						$server='localhost';
						$user='root';
						$password='P@rtyboy1.';
						$baza='labdb_xss';
						$connect = mysqli_connect($server, $user, $password, $baza);
						if(!$connect) echo "Can't connect to database!".'<br>'.mysqli_errno;
						$sql = "SELECT * FROM comments";
						$res = mysqli_query($connect, $sql);				
					?>

							<?php
								while ( $r = mysqli_fetch_assoc($res)) {
							?>
							
								<div class="card " style=" margin-bottom:2%; background-color: #d1ff52; font-size:80%; ">
									<div class="card-header " style="padding:1%; padding-left:2%;">
										<b class="text-dark"><?php echo $r['name'] ?></b>
									</div>
									<div class="card-body" style="padding:1%; padding-left:2%; padding-bottom:0%;">
										<p class="card-text text-dark"><?php echo $r['subject']; ?></p>
										<p class="text-dark font-italic" style="font-size:70%; opacity:0.8;">Posted: <?php echo $r['submittime']; ?></p>
									</div>
								</div>
							<?php } ?> 
				</div>
			</div>
		</div>
		
	</div>	
		
</div>

<div class="fixed-bottom container-fluid" style="margin:auto;">
	<?php 
		require_once("footer.php"); 
	?>
</div>
