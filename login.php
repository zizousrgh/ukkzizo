<?php
if(!isset($_SESSION["user_id"]) ) {
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Digital Perpus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body >
    <div class="container p-5">
      <div class="d-flex justify-content-center">
        <div
          class="card"
          style="
            width: 30rem;
            background: whitesmoke;
          "
        >
          <img src="assets/login.png" class="card-body pt-2" alt="logo" />
          <hr />
            <div class="card-body pt-2">
            <h3 class="card-text text-center">Login DigitalPerpus</h3>
          </div>          
          </div>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<head>
  <meta charset="UTF-8" />
  <title>Eperpus</title>
  <link rel="stylesheet" href="register/register.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
  <div class="container">
    <div class="title">Login</div>
    <div class="content">
      <form action="backend/login.php" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Username/Email</span>
            <input
              type="text"
              placeholder="Enter your username/email"
              required
              name="username_email"
            />
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input
              type="text"
              placeholder="Enter your password"
              required
              name="password"
            />
          </div>
          <p>
            Don't have an account yet?
            <a href="register/register.html" class="text-decoration-none text-primary"
              >Sign Up</a
            >
          </p>
        </div>
        <div class="button">
          <input type="submit" value="Login" />
        </div>
      </form>
    </div>
  </div>
</body>

