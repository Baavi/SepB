<?php
session_start();
// SANITISE INPUT
function sanitise_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (isset($_POST["submit"])) {

    if (isset($_POST["Email"]) && !empty($_POST["Email"])) {
        $Email = $_POST["Email"];
        $Email = sanitise_input($Email);
        //echo "<p> Email: $Email</p>";
        if (isset($_POST["Password"]) && !empty($_POST["Password"])) {
            $Password = $_POST["Password"];
            $Password = sanitise_input($Password);
            //echo "<p> Password: $Password</p>";

            require_once("settings.php"); // connection info

            $conn = @mysqli_connect($host, $user, $pwd, $sql_db, $port);
            // check if connection is successful
            if (!$conn) {
                // Display error msg
                echo "<p class='manage_error'>Database connection failure </p>";
                header("location: index.php");
                exit();
            } else {
                // Upon successful connection
                $sql_table = "Users";
                $user_query = "SELECT * FROM $sql_table WHERE Email = '$Email'";
                $user_result = mysqli_query($conn, $user_query);
                $row = mysqli_fetch_assoc($user_result);
                $pwd = $row["Password"];
                $customer_name = $row["First_Name"];
                //echo "<p> DB Password: $pwd</p>";
                // checks if the execution was successful
                if (!$row) {
                    echo "<p class='manage_error'>Something is wrong with ", $query, "</p>";
                    header("location: index.php?Username=invalid");
                    exit();
                } else {
                    $Password = md5($Password);
                    //echo $Password;
                    //$password_check = password_verify($Password, $pwd); password_verify(),password_hash() cannot be used becouse the current Mercury server doesn't support it
                    if ($Password == $pwd) {
                        $_SESSION["UserID"] = $row["User_ID"];
                        $_SESSION["customer_name"] = $customer_name;
                        //echo "<p>UserID : ", $_SESSION["UserID"],"</p>";
                        // close the database connection
                        mysqli_close($conn);
                        header("location: dashboard.php");
                    } else {
                        header("location: index.php?Password=invalid");
                        exit();
                    }
                }
            }
        } else {
            header("location: index.php?Password=empty");
            exit();
        }
    } else {
        header("location: index.php?Username=empty");
        exit();
    }
}
