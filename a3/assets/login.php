<?php
require_once 'includes/db_connect.inc';
$page_title='Login';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $identity=trim($_POST['identity']);
  $password=$_POST['password'];

  $stmt=mysqli_prepare($conn,"SELECT * FROM users WHERE username=? OR email=?");
  mysqli_stmt_bind_param($stmt,'ss',$identity,$identity);
  mysqli_stmt_execute($stmt);
  $user=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if($user && password_verify($password,$user['password'])){
    $_SESSION['user_id']=$user['user_id'];
    $_SESSION['username']=$user['username'];
    flash('success','Welcome back, '.$user['username'].'!');
    header('Location:index.php');
    exit;
  }

  flash('danger','Invalid login details.');
}

include 'includes/header.inc';
?>

<h1 class="page-title text-center">Login to PetConnect</h1>

<div class="auth-card">
  <form method="post">
    <label class="form-label">Username or Email</label>
    <input class="form-control mb-3" name="identity" required>

    <label class="form-label">Password</label>
    <input class="form-control mb-3" type="password" name="password" required>

    <button class="btn btn-primary w-100">Log In</button>
  </form>

  <p class="text-center mt-4 mb-0 small">
    Don’t have an account?
    <a href="register.php">Register here</a>
  </p>
</div>

<?php include 'includes/footer.inc'; ?>