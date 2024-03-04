<?php
session_start();
$_SESSION['id'] = 0;
$id=0;
$email = null;

function attempt_login($email, $password) {
  require_once "manipulateDB.php";
  $workingDB = new WorkingWithDB(new Db());
  $user = $workingDB->login( $email, $password);
  if($user != -1 && $user["active"] == 1){
    $id = $user["id"];
    $userName = $user["name"];
    $userMail = $user["email"];
    $_SESSION['id'] = $id;
    $_SESSION['userName'] = $userName;
    $_SESSION['email'] = $userMail;
    header('Location: crud.php');

  }
  else if($user != -1 && $user["active"] == 0){
    $id = $user["id"];
    $userName = $user["name"];
    $userMail = $user["email"];
    $_SESSION['id'] = $id;
    $_SESSION['userName'] = $userName;
    $_SESSION['email'] = $userMail;
    $user = $workingDB->getUser($userMail);
    //mailing wont work without changing xampp settings
    $mailheader = "From:user<email>\r\n"; // change this so the mail works
    mail($userMail, "Activation code", $user[0]['activation_code'], $mailheader); 
    header('Location: validate.php');
  }
  else{
    $id=-1;
    $_SESSION['id'] = $id;
  }
}

if($_POST) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  attempt_login($email, $password);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8"/>
  <title>Dimitar Hristov project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/login.css"/>
</head>

<body>
  <div id="login-form-container">
  <h1>Login</h1>
    <?php if($_SESSION['id']==-1):?>
    <h1>Invalid credentials.</h1>
    <?php endif;?>

    <form id="login-form"  method="post">
      <label for="email">Email</label>
      <input type="email" name="email" value="<?=$email?>" required />

      <label for="password">Password</label>
      <input type="password" name="password" />

      <button id="login-btn" type="submit">Sign in</button>
      <a id="registeer-btn" href="registration.php" >Register</a>
    </form>
  </div>
</body>
</html>