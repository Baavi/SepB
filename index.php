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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
    <script src="scripts/login.js"></script>
</head>

<body>
    <?php
    include_once("header.inc");
    ?>
    <br>
    <div class="container">
        <h1>Login</h1><br>
        <form name="form" id="form" method="post" action="processLOGIN.php" novalidate>
            <fieldset>
                <div class="form-group">
                    <label for="Email" class="col-sm-2 col-form-label col-form-label-lg">Enter Email</label>
                    <input type="text" class="form-control form-control-lg" name="Email" id="Email" required="required" placeholder="name@gmail.com">
                    <div class="invalid-feedback">
                        Please provide a valid Email
                    </div>
                </div>

                <div class="form-group">
                    <label for="Password" class="col-sm-2 col-form-label col-form-label-lg">Enter Password</label>
                    <input type="password" class="form-control form-control-lg " name="Password" id="Password" required="required" minlength="8" maxlength="20" placeholder="Password">
                    <div class="invalid-feedback">
                        Please provide a valid Password
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submit"> Log In </button><br>
                <small id="emailHelp" class="form-text text-muted  col-form-label">Don't have an account? Sign
                    Up!</small>
                <a href="signup.php" class="btn btn-primary btn-lg" role="button"> Sign up </a>

            </fieldset>
        </form>
    </div>
    <?php
    include_once("footer.inc");
    ?>
</body>

</html>