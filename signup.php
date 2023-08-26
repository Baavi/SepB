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
    <script src="scripts/signup.js"></script>
</head>

<body>
    <?php
  include_once("header.inc");
  ?>
    <br>
    <div class="container">
        <h1>SignUp</h1><br>
        <form name="form" id="form" method="post" action="processSIGNUP.php">
            <fieldset>

                <div class="form-group">
                    <label for="Firstname" class="col-sm-2 col-form-label col-form-label-lg">Enter First Name</label>
                    <input type="text" required="required" maxlength="20" pattern="[A-Za-z]{1,20}"
                        class="form-control form-control-lg" name=" Firstname" id="Firstname" placeholder="First Name">
                    <div class="invalid-feedback">
                        Please provide a valid First name
                    </div>
                </div>

                <div class="form-group">
                    <label for="Lastname" class="col-sm-2 col-form-label col-form-label-lg">Enter Last Name</label>
                    <input type="text" required="required" maxlength="20" pattern="[A-Za-z]{1,20}"
                        class="form-control form-control-lg" name="Lastname" id="Lastname" placeholder="Last Name">
                    <div class="invalid-feedback">
                        Please provide a valid Last name
                    </div>
                </div>

                <div class="form-group">
                    <label for="Email" class="col-sm-2 col-form-label col-form-label-lg">Enter Email</label>
                    <input type="text" class="form-control form-control-lg" name="Email" id="Email" required="required"
                        placeholder="name@gmail.com">
                    <div class="invalid-feedback">
                        Please provide a valid Email
                    </div>
                </div>

                <div class="form-group">
                    <label for="Password" class="col-sm-2 col-form-label col-form-label-lg">Enter Password</label>
                    <input type="password" class="form-control form-control-lg " name="Password" id="Password"
                        required="required" minlength="8" maxlength="20" placeholder="Password">
                    <div class="invalid-feedback">
                        Please provide a valid Password
                    </div>
                    <small id="passwordHelpBlock" class="form-text text-muted col-form-label">Your password must be
                        8-20 characters
                        long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </small>

                    <div class="form-group">
                        <label for="Cpassword" class="col-sm-3 col-form-label-lg">Confirm Password</label>
                        <input type="password" class="form-control form-control-lg" name="Cpassword" id="Cpassword"
                            required="required" minlength="8" maxlength="20" placeholder="Password">
                        <div class="invalid-feedback">
                            Provided passwords doesnt match
                        </div>
                        <small id="passwordHelpBlock" class="form-text text-muted col-form-label">Please enter your
                            password
                            again.</small>

                    </div>


                    <input type="submit" class="btn btn-primary btn-lg" name="submit" value="submit" />
                    <small id="emailHelp" class="form-text text-muted  col-form-label">Already have an account? Log
                        In!</small>
                    <a href="index.php" class="btn btn-primary btn-lg" role="button"> Log In </a>

            </fieldset>
        </form>
    </div>
    <?php
  include_once("footer.inc");
  ?>
</body>

</html>