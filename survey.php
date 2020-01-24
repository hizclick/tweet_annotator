<head runat="server">
    <title></title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Dialog - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="no-back-button";}
</script> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
      input[type="text"], textarea {

  background-color : #5cb85c; 

}
  </style>
</head>
<body>
    <?php
	echo "1";
    if(isset($_GET['username'])){
       $uname =  $_GET['username'];
    }
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
           $result = mysqli_query($conn,"SELECT * FROM tweet order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           $result2 = mysqli_query($conn,"SELECT tweet_id FROM tweet WHERE tweet = '".$text."'");
           $row2 = mysqli_fetch_array($result);
           $tweet_id = $row2['tweet_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $uname = $_POST['uname'];
            $response = $_POST['sentiment'];
            $id = $_POST['id'];
           $sql = "INSERT INTO sentiment (tweet_id, user_name, sentiment) VALUES ('$id', '$uname', '$response')";
           if ($conn->query($sql) === TRUE) {
            $result = mysqli_query($conn,"SELECT * FROM tweet order by RAND() limit 1");
           $row = mysqli_fetch_array($result);
           $text = $row['tweet'];
           $id = $row['tweet_id'];
           $result2 = mysqli_query($conn,"SELECT tweet_id FROM tweet WHERE tweet = '".$text."'");
           $row2 = mysqli_fetch_array($result);
           $tweet_id = $row2['tweet_id'];
            } 

}
    ?>
            <div id="mytext">
                 
            </div>
            <div class="card text-center border border-danger" style="width: 200rem; margin: 0 auto; float: none;  margin-bottom: 10px; background-color: #5cb85c;">
            <div id="myform card-body" style="width: 200rem; margin: 0 auto; float: none;  margin-bottom: 10px; margin-top: 10%">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="tweet" style="border: none; resize: none; font-size: 34px; line-height: 1.5; color: white; text-align: justify;" disabled>
            <div style="width: 50rem; float: center; margin-left: 700px">
                <p style="color: white; font-size: 28px; padding-left: 100px;"><?php if(isset($text)){echo $text;}?></p><br>
            </div>
            <input type="text" name="uname" style="display: none; background-color: #5cb85c;" value=<?php if(isset($_GET['username'])){echo $_GET['username'];}else if(isset($uname)){echo $uname;}?>>
            <input type="text" name="id" style="display: none; background-color: #5cb85c;" value=<?php if(isset($id)){echo $id;}?>>
            <label class="radio-inline" style="color: white; font-size: 22px"><input class="radio-inline" id="pos" type="radio" name="sentiment" value="positive">Positive</label>
            <label class="radio-inline" style="color: white; font-size: 22px"><input class="radio-inline" id="neg" type="radio" name="sentiment" value="negative">Negative</label>
            <label class="radio-inline" style="color: white; font-size: 22px"><input class="radio-inline" id="neu" type="radio" name="sentiment" value="nuetral"> Neutral</label>
            <label class="radio-inline" style="color: white; font-size: 22px"><input class="radio-inline" id="mix" type="radio" name="sentiment" value="mixed"> Mixed </label>
            <?php if(isset($error)){echo $error;}?><br><br>
            <button type="submit" class="btn btn-lg btn-primary" name="file" id="file" style="margin: 10%;">Save</button>
        </form>
            </div>
        </div>
    </form>
</body>
