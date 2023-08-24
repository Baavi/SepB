<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Web Programming" />
  <meta name="keywords" content="Web,programming" />
  <meta name="author" content="Aishwarya Kaggdas" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  
  
<title>LOGIN Page</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="#">CityLogistics</a> 
  </div>
</nav>
<br>

<div class="container">
   
    <form action="" method="post">
      <fieldset>
        <div class="form-group">
          <label for = "email">Enter Email:</label> 
          <input type="text" class="form-control" name="email" placeholder="name@gmail.com">
        </div>

        <div class="form-group">
          <label for = "password">Enter Password:</label> 
          <input type="password"  class="form-control" name="password" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-primary">Log In</button><br>
        <small id="emailHelp" class="form-text text-muted">Don't have an account? Sign Up!</small>
        <a href="signup.php" class="btn btn-primary" role="button">Sign up</a>

      </fieldset>
    </form>
</div>
</body>
</html>


<?php 
  

// DATABASE CONNECTION

           $dbconnect = @mysqli_connect( "feenix-mariadb.swin.edu.au", "s103170236", "130202", "s103170236_db")
                 or die("<p>Unable to connect to the database server.<p>"
                 . "<p>Error code " . mysqli_connect_errno()
                 . ": " .mysqli_connect_error() . "</p>");

            
            $dbName = "s103170236_db";
                @mysqli_select_db($dbconnect, $dbName)
                or die("<p>Database is not available<p>"
                . "<p>Error code " . mysqli_connect_errno()
                . ": " .mysqli_connect_error() . "</p>");
       

// SANITISE INPUT



function sanitise_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;  
        }


    if(isset($_POST["email"]) && isset($_POST['password'])) 

{
      
       $Email = $_POST["email"];
       $Email = sanitise_input($Email);
    

       $Password = $_POST["password"];
       $Password = sanitise_input($Password);
      

        $sqlString = "SELECT * FROM Users where Email='$Email' and Password='$Password'";
        $queryResult = @mysqli_query($dbconnect, $sqlString)
        or die ("<p>Unable to query the Users table.</p>");
        $num_rows = mysqli_num_rows($queryResult);



      if ($num_rows == 0)  
        {
        echo "<p><font color='red'>"."<strong>Error! </strong>User does not exist, check the Email and Password entered</font></p>";
         
        }
        else
        {
          $row = mysqli_fetch_assoc($queryResult);

          
          
          header("Location: Dashboard.php");
          exit();
        }


}


      ?>
