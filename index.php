<html>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script
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

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
           //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
         }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
              $ip = $_SERVER['REMOTE_ADDR'];
          }
	
$res = mysqli_query($conn, "SELECT count(*) from response where ip = '".$ip."'"); 
$count = mysqli_fetch_array($res);
$sum =  $count[0];
	
?>

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
  <script  src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
     $(function() { 
        var enter = $('#mo').val();
        if(enter !="/"){
                 $("#popModal").modal('show'); }});
</script>
  <script>
	  function cls(){
		  if (confirm("Are you sure you want to close?") == true) {
			          location.replace("final.html");
		  } 
	  }
  </script>


</head>
<body>
    <?php
//for the first time when the user logged in to the system 
if(!isset($_POST['val'])){
           $result = mysqli_query($conn,"SELECT * FROM tweet WHERE counter<2 and tweet_id>2000 order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           $result2 = mysqli_query($conn,"SELECT tweet_id FROM tweet WHERE tweet = '".$text."'");
           $row2 = mysqli_fetch_array($result);
           $tweet_id = $row2['tweet_id'];
           $val = 1;
	   $m = 1;
         }

//after the client click on save button
	
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['sentiment'])){
          
           $result = mysqli_query($conn,"SELECT * FROM tweet WHERE tweet.counter<1 and tweet.tweet_id>2000 order by RAND() limit 1"); //select rows randomly from the table 'tweet'
           
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
	   
	   $text = $row['tweet'];
 	    
	   $response = $_POST['sentiment'];
           $sql = "INSERT INTO response (tweet_id, ip, country, sentiment) VALUES ('$id','$ip','$country','$response')"; // insert the final result to the table called sentiment
           $sql2 ="UPDATE tweet SET counter = counter + 1 WHERE tweet.tweet = '".$text."'";
	    
        $conn->query($sql2);
	    
	    if ($conn->query($sql) === TRUE) {
	   $result = mysqli_query($conn,"SELECT * FROM tweet where tweet_id>2000 order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           
    }
            }
      //if one of the radio button is not selected show error message
      else{
        $text = $_POST['txt'];
        $error = "* እባክዎን አንዱን ምርጫ ይምረጡ";
    }
       }
    ?>
    <!-- end of php
      start of html -->
	
    <!-- Popup Modal -->
<div id="popModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>አንኳን በደህና መጡ</p>
        <p>ከዚህ ቀጥሎ የሚሞሉት ፎርም ላይ የሚመለከቱዋቸው ፅሁፎቸ ከየተለያዩ የአማርኛ ትዊቶች የተሰበሰቡ ሲሆኑ ፤ የዚህ ፕሮጀክት አላማው የአማርኛ ቋንቋ ስሜት ትንተና ለመስራት የሚያስችል ናሙና ለመሰብሰብ ነው። የአርስዎ መልስም ለዚህ ምርምር ብቻ እንደግባትነት የሚያገለግል መሆኑን በአክብሮት አንገልጻለን።</p> 
        <p>ስለትብብሮ እናመሰግናለን!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
 
  </div>
</div>
    <div id="mytext">    
	<div class='dir'>
        <p><u><b>መመሪያ:</b></u><p><br>
          <p>፩. ጽሁፉ አዎንታዊ ከሆነ <b>አዎንታዊ</b> የሚለውን ይምረጡ</p>
          <p>፪. ጽሁፉ አሉታዊ ከሆነ <b>አሉታዊ</b> የሚለውን ይምረጡ</p>
          <p>፫. አዎንታዊም አሉታዊም ካልሆነ <b>ገለልተኛ</b> የሚለውን ይምረጡ</p>
	  <p>፫. አዎንታዊም አሉታዊም ከልሆነ <b>ቅልቅል</b> የሚለውን ይምረጡ</p>
	</div>

     <div  id="top" class="card text-center border border-danger"> <!-- the top card that contain the instraction for filling the form -->
            <div id="myform card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <textarea type="text" name="txt" id="txt"><?php if(isset($text)){echo $text;}?></textarea>
                  <div id="tweet">
                    <p><?php if(isset($text)){echo $text;}?></p><br>
                    <input type="text" name="ip" class="in"  value=<?php if(isset($_GET['ip'])){echo $_GET['ip'];}else if(isset($ip)){echo $ip;}?>>
                    <input type="text" name="id"  class="in" value=<?php if(isset($id)){echo $id;}?>>
                    <input type="text" name="val" class="in" value=<?php if(isset($val)){echo $val;}?>>
                    <input type="text" name="mod" class="in" id="mo" value=<?php if(isset($m)){echo $m;}?>/>
                    <label class="radio-inline" style=""><input class="radio-inline" id="pos" type="radio" name="sentiment" value="positive">አዎንታዊ</label>
                    <label class="radio-inline"><input class="radio-inline" id="neg" type="radio" name="sentiment" value="negative">አሉታዊ</label>
                    <label class="radio-inline"><input class="radio-inline" id="neu" type="radio" name="sentiment" value="nuetral">ገለልተኛ</label>
		    <label class="radio-inline"><input class="radio-inline" id="neu" type="radio" name="sentiment" value="mixed">ቅልቅል</label><br><br><br>
		    <button type="submit" class="btn btn-lg btn-primary" name="file" id="file">መዝግብ</button><br>
                    <button type="button" class="btn btn-lg btn-danger" onclick="cls()" style="margin-left: 80%">ዝጋ</button>


                    <p style="color: red"><?php if(isset($error)){echo $error;}?></p>
		    <p> <?php echo $sum ?> ያህል ዳታ ሞልተዋል</p>

                </form>
          </div>
        </div>
</body>
<!-- end of html -->
