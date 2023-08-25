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
    <title>Login Page</title>
    <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>
    <?php
  include_once("header.inc");
  ?>
    <br>
    <div class="container">
        <h1>Login</h1><br>
        <form name="form" id="form" method="post" action="processLOGIN.php">
            <fieldset>
                <div class="form-group">
                    <label for="Email">Enter Email</label>
                    <input type="text" maxlength="127" required="required" pattern=".{1,127}" class="form-control"
                        name="Email" placeholder="name@gmail.com">
                </div>

                <div class="form-group">
                    <label for="Password">Enter Password</label>
                    <input type="password" maxlength="127" required="required" pattern=".{1,127}" class="form-control"
                        name="Password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary" name="submit" value="submit">Log In</button><br>
                <small id="emailHelp" class="form-text text-muted">Don't have an account? Sign Up!</small>
                <a href="signup.php" class="btn btn-primary" role="button">Sign up</a>

            </fieldset>
        </form>
    </div>
    <?php
  include_once("footer.inc");
  ?>
</body>

</html>