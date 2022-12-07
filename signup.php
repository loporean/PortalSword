<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$name = $_POST['person_name'];
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		//$type = $_POST['FishermanType'];
    $type = "Bass";

    $username_query = "SELECT * FROM Fisherman WHERE Username = '$user_name'"; 
    $username_match = mysqli_query($con, $username_query);

    if(mysqli_num_rows($username_match)>0)
    {
      echo '<script type="text/javascript"> alert("Username already exists") </script>';
      
    }

		else if(!empty($name) && !empty($user_name) && !empty($password) && !empty($type))
		{
			//sequel injection prevention
			$validation = $con->prepare("SELECT * FROM Fisherman WHERE Username=?");
			$validation->bind_param('s', $user_name);
			$validation->execute();

			mysqli_stmt_bind_result($validation, $res_name, $res_user, $res_password);

			if($validation->fetch())
			{ 
				echo "user already exists";
			}
			else
			{
				//save to database
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$query = "CALL RegisterFisherman('$name','$user_name','$hash','$type')"; //STORED PROCEDURE RegisterFisherman

				mysqli_query($con, $query);

				$query = "CALL InsertRole('$user_name', 'user')"; //STORED PROCEDURE InsertRole

				mysqli_query($con, $query);

				//header("Location: userManagement.php");
        echo '<script type="text/javascript"> alert("User Inserted") </script>';
				//die;
			
		  }
    }
    else
    {	
      echo "All Fields Required";
    }
	}
	
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>SignUp | Portal Sword</title>
</head>>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="data.css">

    <div class="video-container">
      <video autoplay muted playsinline loop id="myVideo">
          <source src="Energy Field.mp4" type="video/mp4">
      </video>
  </div>

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
  font-size: 100px;
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
       <!-- <div class="Title">
            <p3>Portal Sword</p3>
        </div>-->
<div class = "content">
<body>
  <div>
    <div class="background">

    <form method="post">
        <h3>SignUp</h3>

        <label for="Full Name">Enter Name</label>
        <input id="text" type="text" name="person_name" placeholder="Full Name" />

        <label for="username">Create Username</label>
        <input type="text" id="text" name="user_name" placeholder="Username" />

        <label for="password">Create Password</label>
        <input type="password" id="text" name="password" placeholder="Password" />

        <button id="button" type="submit" class="button" value="Sign Up" >Sign Up</button>

        <!--<button>SignUp</button>-->
        <div class="social">
            <!--<div class="go">  Sign Up</div>-->

           <!--Have an account?-->
             <div class = "go"><a href="login.php">Login</a></div>
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

    apiKey: "AIzaSyBXLOtIJt_B2FnYuiNYgC97YdgWJZ4NeIs",

    authDomain: "portalswordtest.firebaseapp.com",

    databaseURL: "https://portalswordtest-default-rtdb.firebaseio.com",

    projectId: "portalswordtest",

    storageBucket: "portalswordtest.appspot.com",

    messagingSenderId: "590498309267",

    appId: "1:590498309267:web:56cb0b33ab7fd5a2421966",

    measurementId: "G-CB6F9BE2XP"

  };


  // Initialize Firebase

  const app = initializeApp(firebaseConfig);

  const analytics = getAnalytics(app);


  import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";

const auth = getAuth();

var email = document.getElementById('email').value;
var username = document.getElementById('username').value;
var password = document.getElementById('password').value;

createUserWithEmailAndPassword(auth, email, password)
  .then((userCredential) => {
    // Signed in 
    const user = userCredential.user;
    alert('user created!');
    // ...
  })
  .catch((error) => {
    const errorCode = error.code;
    const errorMessage = error.message;

    alert(errorMessage);
    // ..
  });


</script>

</html>