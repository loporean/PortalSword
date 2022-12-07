<?php
session_start();
INCLUDE("connection.php");
INCLUDE("functions.php");

if($_SESSION['loggedIn']){
//allows user access to page if they are confirmed to be logged in
}
else{
//redirect to the login page
header('Location: login.php'); 
}

?>
<?php
  if(isset($_POST['edit'])) //Update User
  {
    //echo '<script type="text/javascript"> alert("Update Button Pushed") </script>';
    $user_name = $_SESSION['user_name']; // grab username from CURRENT USER
    if(!empty($user_name)) // if username from input is not empty, continue
    {
      $sql = "SELECT * FROM Fisherman WHERE Username = '$user_name'"; // grab conditional query from database

      $getResults = mysqli_query($con, $sql); // put results from query into &getResults

        if(mysqli_num_rows($getResults)>0) // if more than 0 rows come back, continue
        {

          //echo '<script type="text/javascript"> alert("Username Found") </script>'; // alert for testing
         // $new_user_name = $_POST['new_user_name']; // grab new username from input
          $name = $_POST['person_name']; // grab name from input
          $password = $_POST['password']; // grab password from input
          $type = $_POST['FishermanType']; // grab type from input

          if(!empty($name)){
            //echo '<script type="text/javascript"> alert("name") </script>';
          $query = "UPDATE Fisherman SET Fisherman.Name = '$name' WHERE Username = '$user_name'"; 
          mysqli_query($con, $query);
          }

         /* if(!empty($new_user_name)){
          $query = "UPDATE Fisherman SET Fisherman.Username = '$new_user_name' WHERE Username = '$user_name'"; 
          $query_run = mysqli_query($con, $query);
          mysqli_query($con, $query);
          } */

          /* if(!empty($password)){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE Fisherman SET Fisherman.Password = '$hash' WHERE Username = '$user_name'"; 
            mysqli_query($con, $query);
          } */

          if(!empty($type)){
            $query = "UPDATE FishermanType SET FishermanType.Type = '$type' WHERE Username = '$user_name'"; 
            mysqli_query($con, $query);
          }

          if(empty($type) && empty($name)){
              echo '<script type="text/javascript"> alert("No Changes Made") </script>';
          }

                  
        }
      }                       
    }
    
 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userManagement.css">
    <title>Leaderboard</title>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.2/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

</head>

<body>
    <br>
    <div class="container">
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
    <a href="login.php">Logout</a><br>
    <h1>Leaderboard</h1>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Username</th>
                <th>Time</th>
                </tr>
        </thead>
        <tbody>
            <?php
            date_default_timezone_set('America/Los_Angeles');
            error_reporting(E_ALL);
            ini_set("log_errors", 1);
            ini_set("display_errors", 1);

            $id = $_SESSION['user_name'];
            //grab ranking from database whenever get around to implementing.
            // increment by 1 for now.
            $rank = 1;
            // grab time from database. Make random for now.
            //$time = mt_rand(1, 5000);
            $output = array();
            $output[] = mt_rand(1, 5000);

            $result = mysqli_query($con,"SELECT Fisherman.Name as FLname, Fisherman.Username FROM Fisherman"); 
            $result2 = mysqli_query($con,"SELECT Fisherman.Name as FLname, Fisherman.Username FROM Fisherman");

            $i = 0;
            while($row = mysqli_fetch_array($result2))
            {
            
              $output[] = mt_rand(1, 5000);
              $i += 1;
            //rsort($output);
            //$time = mt_rand(1, 5000);
            }
            
            rsort($output);

            while($row = mysqli_fetch_array($result))
            {
            echo "<tr>";
            echo "<td>" . $rank. "</td>";
            echo "<td>" . $row['FLname'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $output[$rank-1] . "</td>";
            echo "</tr>";
            $rank += 1;
            //$output[] = mt_rand(1, 5000);
            //rsort($output);
            //$time = mt_rand(1, 5000);
            }
            echo "</table>";

            ?>

        </div>
              
              <!--  <div class="container">
                  <button class="modal-button" href="#myModal">Update Info</button>--><!-- Edit User -->
            
               <!-- </div><br>-->
                <!-- The Modal -->
               <!-- <div id="myModal" class="modal"> -->

                  <!-- Modal content -->
                <!--  <div class="modal-content">
                    <div class="modal-header">
                      <span class="close">&times;</span>
                      <h2>Update User</h2>
                    </div>
                    <div class="modal-body">-->
                     <!-- <form method="post">
                       
                      <div style="font-size: 20px;margin: 10px;color: white;"></div>
                        
                        <h3>Update Info</h3>
                        Name:     <br><input id="text" type="text" name="person_name"><br><br>
                        <label for="FishermanType">Fisherman Type: </label><br>
                        <select name="FishermanType" id="FishermanType">
                            <option hidden disabled selected value> -- select an option -- </option>
                            <option value="bass">Bass</option>
                            <option value="fly">Fly</option>
                            <option value="spear">Spear</option>
                            <option value="bow">Bow</option>
                            <option value="cat">Cat</option>
                            <option value="fresh">Fresh Water</option>
                            <option value="salt">Salt Water</option>
                        </select><br><br>
                        
                      <input id="button" type="submit" name="edit" value="Edit"><br><br> 
                      </form>
                      -->

                        
                     </div>
                      <!--<div class="modal-footer">
                        <h3></h3>
                      </div> -->
                </div>    
                 </div> 
            
         

        </tbody>

    </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                responsive: true
            } );
        
            new $.fn.dataTable.FixedHeader( table );
        } );
    </script>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>



<script>
// Get the button that opens the modal
var btn = document.querySelectorAll("button.modal-button");

// All page modals
var modals = document.querySelectorAll('.modal');

// Get the <span> element that closes the modal
var spans = document.getElementsByClassName("close");

// When the user clicks the button, open the modal
for (var i = 0; i < btn.length; i++) {
 btn[i].onclick = function(e) {
    e.preventDefault();
    modal = document.querySelector(e.target.getAttribute("href"));
    modal.style.display = "block";
 }
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < spans.length; i++) {
 spans[i].onclick = function() {
    for (var index in modals) {
      if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
    }
 }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
     for (var index in modals) {
      if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
     }
    }
}

</script>

<script type='text/javascript'>
  window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>


</body>
</html>