<?php
include_once('../connection/connect.php');

$error = '';
if(isset($_POST['login'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $password_q = mysqli_query($conn,"SELECT * FROM users WHERE email = '$email';");
  if(mysqli_num_rows($password_q) > 0){
    $user = mysqli_fetch_assoc($password_q);
    $hash_password = $user['password'];
    if(password_verify($pass,$hash_password)){
      $_SESSION['auth'] = $user;
      header("location:../index.php");
    }else{
      $error = "Incorrect Password!";
    }
  }else{
    $error = "Email doesn't Exists.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index.php"><b>Dynamic</b>Dashboard</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if(!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-8">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <p class="mb-1">
        <a href="forgotPassword.php">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>
</html>