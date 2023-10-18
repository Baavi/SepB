<?php
session_start();
if (!isset($_SESSION["customer_name"])) {
  header("location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="description" content="SepB" />
  <meta name="keywords" content="Web,programming" />
  <meta name="author" content="Group 19" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="./styles/style.css" rel="stylesheet" />
  <script src='./scripts/sidebar.js'></script>
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Contact Us</title>
  <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>
  <?php include_once("sidebar.inc"); ?>
  <section class="home-section">
    <?php include_once("navbar.inc"); ?>
    <form name="form" id="contact-form" class="form" action="contact.php" method="POST">
      <h2 class="text-primary">Contact</h2>

      <fieldset>
        <div class="form-group">
          <label for="name" class="col-form-label col-form-label-lg font-weight-bold">Name</label>
          <input name="name" type="text" required="required" maxlength="20" pattern="[A-Za-z ]{1,20}" class="form-control form-control-lg" name=" name" id="name" placeholder="John Smith">
          <div class="invalid-feedback">
            Please provide a valid name
          </div>
        </div>

        <div class="form-group">
          <label for="Email" class="col-form-label col-form-label-lg font-weight-bold">Enter Email</label>
          <input name="Email" type="text" class="form-control form-control-lg" name="Email" id="Email" required="required" placeholder="name@gmail.com">
          <div class="invalid-feedback">
            Please provide a valid Email
          </div>
        </div>

        <div class="form-group">
          <label for="subject" class="col-form-label col-form-label-lg font-weight-bold">Subject</label>
          <input name="subject" type="text" required="required" maxlength="20" pattern="[A-Za-z ]{1,30}" class="form-control form-control-lg" name="subject" id="subject" placeholder="Eg. Issue">
          <div class="invalid-feedback">
            Please provide a valid subject
          </div>
        </div>

        <div class="form-group">
          <label class="col-form-label col-form-label-lg font-weight-bold" for="message" font-weight-bold>Message</label>
          <textarea name="message" class="form-control form-control-lg" id="message" rows="5" placeholder="Message"></textarea>
        </div>

        <div class="button-div">
          <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submit">Send</button>
          <button type="reset" class="btn btn-outline-secondary btn-lg" name="Reset" value="Reset">Clear</button>
        </div>
      </fieldset>
    </form>
    <?php
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $subject = $_POST['subject'];
      $email = $_POST['Email'];
      $message = $_POST['message'];

      $mailto = "103068001@student.swin.edu.au";
      $headers = "From: " . $email;


      mail($mailto, $subject, $message, $headers);

      echo "<div class='alert alert-success' role='alert'>
            The message was successfully sent to the developer team!
            </div>";
    }

    include_once("footer.inc");
    ?>
  </section>
</body>

</html>