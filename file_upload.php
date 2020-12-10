<!DOCTYPE html>
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
<html>
	<head>
		<title>Upload</title>	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			
		</style>
	</head>

	<body class="" style="background-image: url('img/bg_test.png');background-repeat: auto; background-size: 1920px 1080px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<?php require_once("nav.php"); ?>
				</div>
				
				<div class="col-sm-9" style="">
					<div class="row"><h4 style="color: #d1ff52;  margin-top:1%;">File Upload</h4></div>
					<div class="col-sm-4 " style="margin:auto; padding:2%; margin-top:2%; background-color:#c42b1a;">
					
						<form action="file_upload" method="POST" ENCTYPE="multipart/form-data">
							<div class="custom-file">
								<label class="custom-file-label btn dropdown_element" style="background-color: #e83b27;" for="customFile">Choose image</label><input type="file" class="custom-file-input " id="customFile" name="file"><br><br>
							
								<button type="submit" class="btn   dropdown_element" style="background-color: #e83b27;" name="upload">Upload File</button>
							</div>
						</form>				
					</div> 
				
					<div class="col-sm-4 fileinfo bg-warning" style="margin:auto; padding:1%; margin-top:2%; height:15%; font-size:80%;">
					
						<?php
							function upload()
							{
								$max_size = 1024*1024;
								$allowed = array('gif', 'png','jpg');
								$filename = $_FILES['file']['name'];
								$ext = pathinfo($filename, PATHINFO_EXTENSION);
								if ($ext == 'gif' || $ext == 'png' || $ext == 'jpg')
								{
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
								else
								{
									if($_FILES["file"]["error"] !== 4)
									{
										echo '<script type="text/javascript">$(".fileinfo").css("visibility","visible");</script>';
										echo 'File extension is forbbiden!';
									}
								}
							}

							if(isset($_POST['upload']))
							{
								upload();	
							}
						?> 			
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
	</body>
   
</html>