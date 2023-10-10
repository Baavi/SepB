<?php
ob_start(); 

// SANITISE INPUT

function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["submit"])) {
    // Firstname
    if (isset($_POST["Firstname"]) && !empty($_POST["Firstname"])) {
        $Firstname = $_POST["Firstname"];
        $Firstname = sanitise_input($Firstname);
        echo "<p> First Name: $Firstname</p>";
        if (!preg_match("/^[A-Za-z]{1,20}$/", $Firstname)) {
            header("location: signup.php?Firstname=invalid");
            exit();
        }
    } else {
        header("location: signup.php?Firstname=empty");
        exit();
    }

    // Lastname
    if (isset($_POST["Lastname"]) && !empty($_POST["Lastname"])) {
        $Lastname = $_POST["Lastname"];
        $Lastname = sanitise_input($Lastname);
        echo "<p> Last Name: $Lastname</p>";
        if (!preg_match("/^[A-Za-z]{1,20}$/", $Lastname)) {
            header("location: signup.php?Lastname=invalid");
            exit();
        }
    } else {
        header("location: signup.php?Lastname=empty");
        exit();
    }

    // Email
    if (isset($_POST["Email"]) && !empty($_POST["Email"])) {
        $Email = $_POST["Email"];
        $Email = sanitise_input($Email);
        echo "<p> Email: $Email</p>";
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            header("location: signup.php?Email=invalid");
            exit();
        }
    } else {
        header("location: signup.php?Email=empty");
        exit();
    }

    //  PASSSWORD
    if (isset($_POST["Password"]) && !empty($_POST["Password"])) {
        $Password = $_POST["Password"];
        $Password = sanitise_input($Password);
        echo "<p> Password: $Password</p>";
        if (!preg_match("/^[A-Za-z@'0-9]{8,20}$/", $Password)) {
            header("location: signup.php?Password=invalid");
            exit();
        }
    } else {
        header("location: signup.php?Password=empty");
        exit();
    }

    // CONFIRM PASSSWORD
    if (isset($_POST["Cpassword"]) && !empty($_POST["Cpassword"])) {
        $Cpassword = $_POST["Cpassword"];
        $Cpassword = sanitise_input($Cpassword);
        echo "<p> Cpassword: $Cpassword</p>";
        if (strcmp($Password, $Cpassword) != 0) {
            header("location: signup.php?Cpassword=invalid");
            exit();
        }
    } else {
        header("location: signup.php?Cpassword=empty");
        exit();
    }

    // connection info
    require_once("settings.php");

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db, $port);
    // check if connection is successful
    if (!$conn) {
        // Display error msg
        echo "<p class='manage_error'>Database connection failure </p>";
        header("location: signup.php?Server=error");
        exit();
    } else {
        // Upon successful connection
        $sql_table = "Users";
        $table_query = "CREATE TABLE IF NOT EXISTS $sql_table
        ( UserID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
        First_Name VARCHAR(20) NOT NULL,
        Last_Name VARCHAR(20) NOT NULL,
        Email VARCHAR(50) NOT NULL,
        Password VARCHAR(50) NOT NULL);";

        $table_result = mysqli_query($conn, $table_query);

        // checks if the execution was successful
        if (!$table_result) {
            echo "<p>Something is wrong with ", $query, "</p>";
            header("location: signup.php?Server=error");
            exit();
        }

        // Encrypting Password
        $MD5 = md5($Password);
        $sqlString = "INSERT INTO Users(First_Name,Last_Name,Email,Password) 
                                    VALUES('$Firstname','$Lastname','$Email','$MD5')";

        $queryResult = @mysqli_query($conn, $sqlString);

        // checks if the execution was successful
        if (!$queryResult) {
            echo "<p>Something is wrong with ", $queryResult, "</p>";
            header("location: signup.php?Server=error");
            exit();
        }
        echo "<p>Successfully inserted data in the table.</p>";
        // close the database connection
        mysqli_close($conn);
        header("location:index.php");  //Redirects to 'index.php’ page
    }
}