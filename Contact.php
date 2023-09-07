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
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Contact Us</title>
  <link rel="icon" href="styles/images/logo.svg" type="image/icon" />
</head>

<body>
<div class="sidebar bg-primary">
    <div class="logo-details">
      <i class="bx bx-sitemap"></i>
      <span class="logo_name">CityLogistics</span>
    </div>
    <ul class="nav-links">
      <li class="bg-primary">
        <a href="#" class="active">
          <i class="bx bxs-dashboard"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bxs-truck"></i>
          <span class="links_name">Search by truck</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-package"></i>
          <span class="links_name">Search by micro hubs</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-message-rounded-dots'></i>
          <span class="links_name">Contact Us</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Contact Us</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
      <div class="profile-details">
        <img src="./assets/images/ava1.jpeg" alt="" />
        <span class="admin_name">John Doe</span>
        <i class="bx bx-chevron-down"></i>
      </div>
    </nav>
    <br>
    
    <div class="container">
            
    <form name="form" id="form" class="form" action="https://formspree.io/f/mzblgywo;" method="POST">
      <fieldset>
        <div class="form-group">  
          <label for="Firstname" class="col-sm-2 col-form-label col-form-label-lg">First Name</label>
          <input name="FirstName" type="text" required="required" maxlength="20" pattern="[A-Za-z]{1,20}"
            class="form-control form-control-lg" name=" Firstname" id="Firstname" placeholder="John">   
              <div class="invalid-feedback">
                 Please provide a valid First name
               </div>
       </div>
                
        <div class="form-group">
          <label for="Lastname" class="col-sm-2 col-form-label col-form-label-lg">Last Name</label>
          <input name="LastName" type="text" required="required" maxlength="20" pattern="[A-Za-z]{1,20}"
            class="form-control form-control-lg" name="Lastname" id="Lastname" placeholder="Smith">
             <div class="invalid-feedback">
               Please provide a valid Last name
             </div>
        </div>

       <div class="form-group">
          <label for="Email" class="col-sm-2 col-form-label col-form-label-lg">Enter Email</label>
          <input name="Email" type="text" class="form-control form-control-lg" name="Email" id="Email" required="required"
            placeholder="name@gmail.com">
              <div class="invalid-feedback">
                Please provide a valid Email
               </div>
       </div>

       <div class="form-group">
          <label  class="col-sm-2 col-form-label col-form-label-lg" for="message">Message</label>
          <textarea name="message" class="form-control form-control-lg" id="message" rows="5" placeholder="Message"></textarea>
      </div>
        
        <div class="button-div">
          <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submit">Send</button>
          <button type="reset" class="btn btn-primary btn-lg" name="Reset" value="Reset">Clear</button>
        </div>
     </fieldset> 
    </form>
    </div>
    <?php
     include_once("footer.inc");
    ?>

  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    };
  </script>
</body>

</html>