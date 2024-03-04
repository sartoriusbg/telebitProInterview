<?php
require_once 'manipulateDB.php';
session_start();

if ($_SESSION["id"] < 1) {
    header('Location: login.php');
}
$_SESSION['validated'] = 0;
$workingDB = new WorkingWithDB();
echo '<h1>'.$_SESSION['email'].'</h1>';
$user = $workingDB->getUser($_SESSION['email']);
if($_POST) {
    $code = $_POST['code'];
    if($code == $user[0]['activation_code'])
    {
        $workingDB->validateUser($_SESSION['email']);
        header('Location: crud.php');
    }
    else
    {
        $_SESSION['validated'] = -1;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dimitar Hristov project</title>
  <link rel="stylesheet" href="css/validate.css">
</head>
<body>
  <div class="container">
    <h1>Email validation</h1>
    <?php if($_SESSION['validated'] == -1):?>
    <h1>Invalid code.</h1>
    <?php endif;?>
    

    <form id="login-form"  method="post">
      <label for="code">Activation code</label>
      <input type="code" name="code" required />
      <button id="validate-btn" type="submit">Validate</button>
      <a id="login-btn" href="login.php" >Back to login</a>
    </form>
</body>
</html>