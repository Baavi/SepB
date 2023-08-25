<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="SepB" />
    <meta name="keywords" content="Web,programming" />
    <meta name="author" content="Group 19" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="styles/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>SignUp Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>
    <?php
  include_once("header.inc");
  ?>
    <br>
    <div class="container">
        <h1>SignUp</h1><br>
        <form action="" method="post">
            <fieldset>

                <div class="form-group">
                    <label for="Firstname">Enter First Name:</label>
                    <input type="text" class="form-control" name="Firstname" placeholder="First Name">
                </div>

                <div class="form-group">
                    <label for="Lastname">Enter Last Name:</label>
                    <input type="text" class="form-control" name="Lastname" placeholder="Last Name">
                </div>

                <div class="form-group">
                    <label for="email">Enter Email:</label>
                    <input type="text" class="form-control" name="email" placeholder="name@gmail.com">
                </div>

                <div class="form-group">
                    <label for="password">Enter Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <small id="passwordHelpBlock" class="form-text text-muted">Your password must be 8-20 characters
                        long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </small>

                    <div class="form-group">
                        <label for="cpassword">Confirm Password:</label>
                        <input type="password" class="form-control" name="cpassword" placeholder="Password">
                        <small id="passwordHelpBlock" class="form-text text-muted">Please enter your password
                            again.</small>
                    </div>


                    <input type="submit" class="btn btn-primary" value="Create an Account" />

            </fieldset>
        </form>
    </div>
    <?php
  include_once("footer.inc");
  ?>
</body>

</html>



<?php


// DATABASE CONNECTION

$dbconnect = @mysqli_connect("feenix-mariadb.swin.edu.au", "s103170236", "130202", "s103170236_db")
  or die("<p>Unable to connect to the database server.<p>"
    . "<p>Error code " . mysqli_connect_errno()
    . ": " . mysqli_connect_error() . "</p>");


$dbName = "s103170236_db";
@mysqli_select_db($dbconnect, $dbName)
  or die("<p>Database is not available<p>"
    . "<p>Error code " . mysqli_connect_errno()
    . ": " . mysqli_connect_error() . "</p>");


// SANITISE INPUT



function sanitise_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}




if (isset($_POST["email"])  && isset($_POST['Firstname'])  && isset($_POST['Lastname']) && isset($_POST['password'])  && isset($_POST['cpassword'])) {

  $Email = $_POST["email"];
  $Email = sanitise_input($Email);


  $FirstName = $_POST["Firstname"];
  $FirstName = sanitise_input($FirstName);


  $LastName = $_POST["Lastname"];
  $LastName = sanitise_input($LastName);


  $Password = $_POST["password"];
  $Password = sanitise_input($Password);


  $CPassword = $_POST["cpassword"];
  $CPassword = sanitise_input($CPassword);



  // ERROR MESSAGES


  $errMsg = "";


  if (empty($Email)) {

    $errMsg .= "<p> Please enter your email id<p>";
  } elseif (!preg_match("/^[a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[a-zA-z0-9.-]{1,4}$/", $Email)) {

    $errMsg .= "<p> Enter a valid email id.</p>";
  }



  if ($FirstName == "") {
    $errMsg .= "<p>Please enter First Name.</p>";
  } elseif (!preg_match("/^[a-zA-Z ]+$/", $FirstName)) {

    $errMsg .= "<p> Please enter First Name which has only letters .</p>";
  }


  if ($LastName == "") {
    $errMsg .= "<p>Please enter Last Name.</p>";
  } elseif (!preg_match("/^[a-zA-Z ]+$/", $LastName)) {

    $errMsg .= "<p> Please enter Last Name which has only letters .</p>";
  }





  //PASSWORD



  if ($Password == "") {
    $errMsg .= "<p>Please enter Password.</p>";
  } elseif (!preg_match("/^[a-zA-Z'0-9]+$/", $Password)) {

    $errMsg .= "<p> Please enter a Valid Password.</p>";
  } elseif (strlen($Password) < "8") {

    $errMsg .= "<p>Password should have more than 8 characters.</p>";
  }


  // CONFIRM PASSSWORD

  if ($CPassword == "") {
    $errMsg .= "<p>Please re-enter the Password.</p>";
  } elseif (strcmp($Password, $CPassword) != 0) {

    $errMsg .= "<p> Password and confirm password do not match.</p>";
  }



  // ECHO error messgaes

  if ($errMsg != "") {
    echo "<p><font color='red'>" . "<Strong>ERROR !!</Strong>" . $errMsg . "</font></p>";
  }

  // ADD FORM DATA TO MYSQL TABLES

  else {




    if (!$dbconnect) {

      echo "<p>Database connection failure</p>";
    } else {
      $MD5 = md5($Password);
      $sqlString = "INSERT INTO Users(First_Name,Last_Name,Email,Password,Confirm_Password) 
                              VALUES('$FirstName','$LastName','$Email','$MD5','$MD5')";

      $queryResult = @mysqli_query($dbconnect, $sqlString)
        or die("<p>Unable to execute insert query.</p>"
          . "<p>Error code " . mysqli_errno($dbconnect)
          . ": " . mysqli_error($dbconnect) . "</p>");
      echo "<p>Successfully inserted data in the table.</p>";
      mysqli_close($dbconnect);


      header("location:index.php");  //Redirects to 'index.php’ page



    }
  }
}





?>