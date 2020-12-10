
<form  method="POST" action="/lab" >
	<button type="submit" id="commit" style="background-color:#b1de35; margin-right:5%;  margin-bottom:5%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons d-none" name="complete"><i class=""></i> Commit solution </button>
	<button type="submit" style="background-color:#b1de35;   margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; " class="btn button form_buttons " name="giveup"><i class=""></i> Discharge Laboratory </button>
</form>

<div  class="col-sm-12" id="labcore" style="border-radius:10px; background: rgba(134,142,150,0.6);">

	<div class="row"><h4 style="color: #d1ff52; margin:auto; margin-top:3%; margin-bottom:3%;">FI Lab 1</h4></div>
	<div class="row" style="padding:3%;">
		<div class="col-12">


			<form action="lab" method="POST" ENCTYPE="multipart/form-data">
				
				
					
					<input type="file" class="  btn button form_buttons" id="customFile" name="file" accept="image/png, image/jpeg, image/gif" onchange="return fileValidation()" ><br><br>
					<button type="submit" onclick="checkkfile()" class="btn   dropdown_element" style="background-color:#b1de35; margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b;" name="upload">Upload File</button>
						<script> 
							function fileValidation() {  //https://www.geeksforgeeks.org/file-type-validation-while-uploading-it-using-javascript/
								var fileInput =  
									document.getElementById('customFile'); 
								
								var filePath = fileInput.value; 
							
								// Allowing file type 
								var allowedExtensions =  
										/(\.jpg|\.jpeg|\.png|\.gif)$/i; 
								
								if (!allowedExtensions.exec(filePath)) { 
									alert('Invalid file type'); 
									fileInput.value = ''; 
									return false; 
								}  
								else  
								{ 
								
									// Image preview 
									if (fileInput.files && fileInput.files[0]) { 
										var reader = new FileReader(); 
										reader.onload = function(e) { 
											document.getElementById( 
												'imagePreview').innerHTML =  
												'<img src="' + e.target.result 
												+ '"/>'; 
										}; 
										
										reader.readAsDataURL(fileInput.files[0]); 
									} 
								} 
							} 
						</script> 
			</form>				
					<div class="btn button form_buttons fileinfo" style="background-color:#b1de35; margin-bottom:1%;  border: 1px  solid #8aad28; color:#2b2b2b; ">

						<?php
							function upload()
							{
								$max_size = 1024*1024;
								//$allowed = array('gif', 'png','jpg');
								$filename = $_FILES['file']['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);

									echo '<script type="text/javascript">$(".fileinfo").css("visibility","visible");</script>';
									if (is_uploaded_file($_FILES['file']['tmp_name']))
									{
										if ($_FILES['file']['size'] > $max_size)
										{
											echo 'Error! File size is too large!';
										}
										elseif (!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$_FILES['file']['name']))
										{

											echo 'File successfully uploaded:';
											echo '<br/>';
											echo '../../uploads/'.$_FILES['file']['name'].'<br>';
											if (isset($_FILES['file']['type']))
											{
												echo 'Type: '.$_FILES['file']['type'].'<br/>';
											}
											move_uploaded_file($_FILES['file']['tmp_name'],
											$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$_FILES['file']['name']);


											if(($ext != 'gif') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png') && ($ext != 'JPEG') && ($ext != 'PNG') && ($ext != 'GIF') && ($ext != 'JPG') ){
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
											$sql = "UPDATE course_content SET status='YES' WHERE (course_content.course_ID = 6 AND course_content.title = 'File Inclusion lab 1 title') AND (course_content.user_ID = $id) "; // ZMIENIC TITLE NA WYNIK SELECTA Z BAZY DANYCH
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
										}
										else
										{
											echo 'Such named file already exists!';
										}
									}
									else
									{
										echo 'There were some issues during file upload process!';
									}


							}

							if(isset($_POST['upload']))
							{
								upload();	
							}
						?> 			
					</div>
					
				
				
</div>

<div class="fixed-bottom container-fluid" style="margin:auto;">
	<?php 
		require_once("footer.php"); 
	?>
</div>