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
