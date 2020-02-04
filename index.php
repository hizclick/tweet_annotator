<head runat="server">
    <title>Tweet annotator</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Dialog - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script>
	  function cls(){
		  if (confirm("Are you sure you want to close?") == true) {
    				window.open("final.html")
  			} 
	  }
  </script>
</head>
<body>
    <?php
//declaring connection variables
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
//for the first time when the user logged in to the system 
if(!isset($_POST['val'])){
           $result = mysqli_query($conn,"SELECT * FROM tweet order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           $result2 = mysqli_query($conn,"SELECT tweet_id FROM tweet WHERE tweet = '".$text."'");
           $row2 = mysqli_fetch_array($result);
           $tweet_id = $row2['tweet_id'];
           $val = 1;
         }

//after the client click on save button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['sentiment'])){
          
           $result = mysqli_query($conn,"SELECT * FROM tweet order by RAND() limit 1"); //select rows randomly from the table 'tweet'
           
	   $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           
	   $result2 = mysqli_query($conn,"SELECT tweet_id FROM tweet WHERE tweet = '".$text."'"); //select the 'tweet id' of specific id from the table tweet
           $row2 = mysqli_fetch_array($result);
           $tweet_id = $row2['tweet_id'];
    	  
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
           //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
    	   }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        		//ip pass from proxy
        		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
   	 		}else{
        			$ip = $_SERVER['REMOTE_ADDR'];
    			}
    

	  
	   
	   $ipdat = @json_decode(file_get_contents( 
            "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
           $country =  $ipdat->geoplugin_countryName;
	   
	   $response = $_POST['sentiment'];
           $sql = "INSERT INTO response (tweet_id, ip, country, sentiment) VALUES ('$id','$ip','$country','$response')"; // insert the final result to the table called sentiment
           
	    
	    if ($conn->query($sql) === TRUE) { //do the sabove if data is successfuly insereted into the database
           
	   $result = mysqli_query($conn,"SELECT * FROM tweet order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           
    }
            }
      //if one of the radio buttons are not selected show error message
      else{
        $text = $_POST['txt'];
        $error = "* እባክዎን አንዱን ምርጫ ይምረጡ";
    }
       }
    ?>
    <!-- end of php
      start of html -->
    <div id="mytext">    
      <p>
        <u><b>መመሪያ:</b></u><br>
          ፩. ጽሁፉ አዎንታዊ ከሆ <b>አዎንታዊ</b> የሚለውን ይምረጡጥ<br>  
          ፪. ጽሁፉ አሉታዊ ከሆነ <b>አሉታዊ</b> የሚለውን ይምረጡጥ<br> 
          ፫. አዎንታዊም አሉታዊም ካልሆነ <b>ገለልተኛ</b> የሚለውን ይምረጡ<br>
          ፭. ጽሁፉ አዎንታዊም አሉታዊም ከሆነ <b>ቅልቅል</b> የሚለውን ይምረጡ<br>
      </p>
      <div  id="top" class="card text-center border border-danger"> <!-- the top card that contain the instraction for filling the form -->
            <div id="myform card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <textarea type="text" name="txt" id="txt"><?php if(isset($text)){echo $text;}?></textarea>
                  <div id="tweet">
                    <p><?php if(isset($text)){echo $text;}?></p><br>
                    <input type="text" name="ip" class="in"  value=<?php if(isset($_GET['ip'])){echo $_GET['ip'];}else if(isset($ip)){echo $ip;}?>>
                    <input type="text" name="id"  class="in" value=<?php if(isset($id)){echo $id;}?>>
                    <input type="text" name="val" class="in" value=<?php if(isset($val)){echo $val;}?>>
                    <label class="radio-inline" style=""><input class="radio-inline" id="pos" type="radio" name="sentiment" value="positive">አዎንታዊ</label>
                    <label class="radio-inline"><input class="radio-inline" id="neg" type="radio" name="sentiment" value="negative">አሉታዊ</label>
                    <label class="radio-inline"><input class="radio-inline" id="neu" type="radio" name="sentiment" value="nuetral">ገለልተኛ</label>
                    <label class="radio-inline"><input class="radio-inline" id="mix" type="radio" name="sentiment" value="mixed">ቅልቅል</label><br>
                    <button type="submit" class="btn btn-lg btn-primary" name="file" id="file" style="margin: 10%;">መዝግብ</button>
		    <button type="button" class="btn btn-lg btn-primary" onclick="cls()" style="margin: 10%;">ዝጋ</button>
                    <p style="color: red"><?php if(isset($error)){echo $error;}?></p>
                </form>
          </div>
        </div>
</body>
<!-- end of html -->
