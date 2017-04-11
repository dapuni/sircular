<!DOCTYPE html>
<html lang="en">
  <head>
	<base href="<?php echo base_url()?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sircular</title>

    <!-- Bootstrap -->
    <link href="assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="assets/gentelella/build/css/custom.min.css" rel="stylesheet">

    <!-- Custom Jquery UI -->
	<link rel="stylesheet" type="text/css" href="assets/jqueryui/jquery-ui.min.css">
	<script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/jqueryui/jquery-ui.min.js"></script>


  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="login/do_login" method="post">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required >
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required >
              </div>
              <div>
              	<button class="btn btn-default submit">Login</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <p>©2016 All Rights Reserved. MRA Media Group</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
