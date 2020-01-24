<!DOCTYPE html>
<html>
<head>
  <title>Tweeter data annotation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script>
</head>
<body>
	<?php 
	$servername = "kcpgm0ka8vudfq76.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
	$username = "kcpqmduod16lyyh2";
	$password = "dahm3oxh2cakdjm8";
	$db = "vnb273g86ehntst1";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['login'])){
			$uname = $_POST['username'];
			$sql = "SELECT * FROM user WHERE username= '".$uname."'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row){
				$url = "survey.php?username=" .$uname;
  				header("Location: $url");

			}else{
				$error = "incorrect username";
			}

}
}
	?>
	<div class="card bg-success text-center border border-danger" style="width: 100rem; margin: 0 auto; float: none;  margin-bottom: 10px;">
  <div class="card-body" style="width: 100rem; margin: 0 auto; float: none;  margin-bottom: 10px; margin-top: 10%">
  	<p style="font-size: 30px;   line-height: 1.5;   text-align: justify; padding: 10%;">
	  		እንኳን ደህና መጡ<br> ከታች ባለው ሳጥን ውስጥ የተጠቃሚ ስም በማስገባት ቀጥሎ ያለውን ፎርም ይሙሉ። ሰለ ትብብሮ አናመስግናለን። <br>

መመሪያ=<br>
    ፩ ጽሁፉ አወንታዊ ከሆነ አወንታዊ የሚለውን ይምረጡጥ<br>  
    ፪ ጽሁፉ አሉታዊ ከሆነ አሉታዊ የሚለውን ይምረጡጥ<br>
    ፫ አወንታዊም አሉታዊም ካልሆነ ገለልተኛ የሚለውን ይምረጡ<br>
    ፭ ጽሁፉ ሁለቱንም ካልሆነ ቅልቅል የሚለውን ይምረጡ<br>

አናመሰግናለን!</p>
  	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="text" name="username" class="form-control input-lg" style="width: 400px; margin: 0 auto; float: none;  margin-bottom: 10px; "><br>
		<input type="submit"  name="login" value="Login" class="btn btn-lg btn-primary" style="margin-bottom: 10%">
		<?php if(isset($error)){
				echo $error;
		} ?>

	</form>
  </div>
</div>
</body>
</html>
