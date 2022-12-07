<?php 

session_start();

	include("connection.php");
	include("functions.php");

	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		$validation = $con->prepare("SELECT * FROM Fisherman WHERE Username=?");
    	$validation->bind_param('s', $user_name);
    	$validation->execute();

    	mysqli_stmt_bind_result($validation, $res_name, $res_user, $res_password);

    	$genericErrorMsg = "Invalid username and/or password";
		if ($validation->fetch() && password_verify($password, $res_password)) 
		{
			
				$_SESSION['user_name'] = $res_user;
				$_SESSION['loggedIn'] = true; //Sets logged in to true if username and password are correct
				$_SESSION["is_admin"] = false;
				$validation->close();

				//checks if user is an admin
				//If they are they will be redirected to the admin page
				$isAdminStatement = $con->prepare("CALL IsAdmin(?)");
				if (!$isAdminStatement) {
					echo "ERROR!";
				}
				$isAdminStatement->bind_param('s', $res_user);
				$isAdminStatement->execute();
				mysqli_stmt_bind_result($isAdminStatement, $res_admin);
				$isAdminStatement->fetch();

				$_SESSION["is_admin"] = $res_admin;
				
				if($res_admin)
				{
					header('Location: leaderboard.php');
					die;
				}
				
				
				header("Location: leaderboard.php");
				die;			
		}
		else
		{
			echo "$genericErrorMsg";
		}
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Portal Sword</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <div class="video-container">
        <video autoplay muted playsinline loop id="myVideo">
            <source src="Energy Field.mp4" type="video/mp4">
        </video>
    </div>

    <audio id="player" autoplay loop>
        <source src="Adventure.mp3" type="audio/mp3">
    </audio>
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
/*.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}*/
/*.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}*/
form{
    height: 510px; 
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(4px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 25px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 55px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.social{
  margin-top: 30px;
  display: flex;
}
.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
}
.social div:hover{
  background-color: rgba(255,255,255,0.47);
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}
/*
#myVideo {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  min-width: 100%;
  min-height: 100%;
  object-fit: cover;
}*/
.video-container {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 100%;
  height: 100%; 
  overflow: hidden;
}
.video-container video {
  /* Make video to at least 100% wide and tall */
  min-width: 100%; 
  min-height: 100%; 

  /* Setting width & height to auto prevents the browser from stretching or squishing the video */
  width: auto;
  height: auto;

  /* Center the video */
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}

/* Add some content at the bottom of the video/page */
.content {
  position: fixed;
  /* bottom: 0; */
  top: 60%;
  left: 50%;
  background: rgba(0, 0, 0, 0.5);
  color: #f1f1f1;
  /* width: 100%; */  
  /* padding: 20px; */
  transform: translate(-50%, -50%);
}
.Title {
  /*height: 230px;*/
  font-size: 50px;
  position: fixed;
  /* bottom: 0; */
  top: 20%;
  left: 50%;
  /*background: rgba(0, 0, 0, 0.5);*/
  color: #f1f1f1;
  /* width: 100%; */  
  /* padding: 20px; */
  transform: translate(-50%, -50%);
}
a {
      text-decoration:none;
   }

    </style>
        <!--<div class="Title">
            <p3>Portal Sword</p3>
        </div>-->
<div class = "content">
<body>
    <div class="background">
    </div>
    <form method="post">
        <h3>Login</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" id="text" name="user_name">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="text" name="password">

        <button type="submit" class="button" id="button" value="Log In" >Log In</button>

        <div class="social">

           
             <div class = "go"><a href="signup.php">Sign Up</a></div>
          </div>
    </form>
    </div>

    <script> // blurs username signaling that it cannot be changed by user
        function inputBlur(i) {
            if (i.value == "") { i.value = i.defaultValue; i.style.color = "#888"; }
        }
        </script>
        <script>
        // Get the video
        var video = document.getElementById("myVideo");
        
        // Get the button
        var btn = document.getElementById("myBtn");
        
        // Pause and play the video, and change the button text
        function myFunction() {
          if (video.paused) {
            video.play();
            btn.innerHTML = "Pause";
          } else {
            video.pause();
            btn.innerHTML = "Play";
          }
        }
        </script>

        <!-- Firebase --><!--
        <script>
          // Initialize Firebase
          var firebaseConfig = {
            apiKey: "AIzaSyCbTQF7wZea2sCODzqS8-bJl4agGIjUnzc",
            authDomain: "portalsword-csub-db.firebaseapp.com",
            databaseURL: "https://portalsword-csub-db-default-rtdb.firebaseio.com/",
            projectId: "portalsword-csub-db",
            storageBucket: "portalsword-csub-db.appspot.com",
            messagingSenderId: "1017847434202",
            appId: "1:1017847434202:web:70a8498ecde909ee338ee3",
            measurementId: "G-V592LER3YT"
          };
          firebase.initializeApp(firebaseConfig);
          const analytics = getAnalytics(app);
        </script>

        <script>
          // Read data from the "users" node in the Realtime Database
          var usersRef = firebase.database().ref("users");
          usersRef.on("value", function(snapshot) {
          console.log(snapshot.val());
          });
        </script>

        <script type="module">
          // Get a reference to the database
          var database = firebase.database();
        
          // Get a reference to the "users" node in the database
          var usersRef = database.ref("users");
        
          // Try to find the user with the specified username
          var userRef = usersRef.child(username);
          userRef.once("value", function(snapshot) {
            // Check if the username was found
            if (snapshot.exists()) {
              // Get the user data
              var user = snapshot.val();
        
              // Check if the password matches
              if (user.password === password) {
                // Login successful
                console.log("Login successful!");
              } else {
                // Password doesn't match
                console.log("Incorrect password!");
              }
            } else {
              // Username not found
              console.log("Username not found!");
            }
          });
        </script>
      -->
</body>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.14.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCbTQF7wZea2sCODzqS8-bJl4agGIjUnzc",
    authDomain: "portalsword-csub-db.firebaseapp.com",
    databaseURL: "https://portalsword-csub-db-default-rtdb.firebaseio.com",
    projectId: "portalsword-csub-db",
    storageBucket: "portalsword-csub-db.appspot.com",
    messagingSenderId: "1017847434202",
    appId: "1:1017847434202:web:70a8498ecde909ee338ee3",
    measurementId: "G-V592LER3YT"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);

</script>

</html>