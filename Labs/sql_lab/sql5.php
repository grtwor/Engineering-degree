
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>

<div  class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6);">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; margin-bottom:3%;">SQL LAB 5</h4></div>
	<div class="row" style="padding:3%;">
		<div class="col-12">



				<?php
						error_reporting(0);
						ini_set('display_errors', 0);
						echo'
						<script>
							loginform.classList.add("d-none"); 				
						</script>
						<div class="container-fluid">
							<div class="col-12" >
								<form  method="GET" action="/lab">
									<button type="submit" id="showdocs" value="all" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="fas fa-calendar-alt"></i> All Docs </button>
									<button type="submit" id="showdocs19" value="2019" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="far fa-calendar-alt	"></i> 2019 Docs </button>
									<button type="submit" id="showdocs20" value="2020" style="background-color:#b1de35; color:#2b2b2b; margin-top:1%; margin-bottom:2%; margin-right:1%;" class="btn button form_buttons float-left" name="show_docs"><i class="far fa-calendar-alt	"></i> 2020 Docs </button>
								</form>
							</div>
						';
						
						if(isset($_GET['show_docs']))
						{
							$success = FALSE;
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
										<tr>';

									$sql = "SHOW COLUMNS FROM docs";
									$result = $connect->query($sql);
									while($row = mysqli_fetch_array($result)){
										if(($row['Field'] != "sensitiveData") && ($row['Field'] != "ID"))
										echo'<th scope="col">'.$row['Field'].' </th>';
									}
									
									echo '
										</tr>
									</thead>
									<tbody>

								
								';
									if($_GET['show_docs'] == "all")
									{
										$sql = "SELECT name, status FROM docs"; 
									}
									elseif($_GET['show_docs'] != "all")
									{
										$sql = "SELECT name, status, created FROM docs WHERE YEAR(created) = '$data' ";
									}
																	
									
									$result = $connect->query($sql);
									$counter = 0;

									while($row = mysqli_fetch_array($result)) 
									{


										$name =  $row['name'];
										$status = $row['status'];
										$created =  $row['created'];
										//$sensitiveData =  $row['sensitiveData'];
										$counter += 1;
										

										echo'
										<tr>

											<th scope="row">'.$name.'</th>
											<td>'.$created.'</td>
											<td>'.$status.'</td>
											
										</tr>';
										if( $name == "10.1.32-MariaDB" or $status == "10.1.32-MariaDB") $success = TRUE;
									}
									if($success)
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
											$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 3 AND course_content.title = 'Lab 5 - SQL injection attack, querying the database type and version on MySQL') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
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

								echo '
									</tbody>
								</table>
							</div>';
						}else
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
										<tr>';

									$sql = "SHOW COLUMNS FROM docs";
									$result = $connect->query($sql);
									while($row = mysqli_fetch_array($result)){
										if(($row['Field'] != "sensitiveData") && ($row['Field'] != "ID"))
										echo'<th scope="col">'.$row['Field'].' </th>';
									}
									
									echo '
										</tr>
									</thead>
									<tbody>

								
								';
	
									$sql = "SELECT name,status FROM docs"; 

																	
									
									$result = $connect->query($sql);
									$counter = 0;

									while($row = mysqli_fetch_array($result)) 
									{
									
										$name =  $row['name'];
										$status = $row['status'];
										$created =  $row['created'];
										
										//$sensitiveData =  $row['sensitiveData'];
										$counter += 1;

										echo'
										<tr>

											<th scope="row">'.$name.'</th>
											<td>'.$status.'</td>
											<td>'.$created.'</td>	
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