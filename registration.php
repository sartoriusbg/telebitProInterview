<!DOCTYPE html>
<html>
<head>
  <title>Dimitar Hristov project</title>
  <link rel="stylesheet" href="css/registration.css">
</head>
<body>
  <div class="container">
    <h1>Registration</h1>

    <?php
      require_once 'manipulateDB.php';

      $workingDB = new WorkingWithDB();
      $users = $workingDB->getUsers();

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $correct=1;

        foreach($users as $u){
         $tempEmail = $u["email"];
         $tempName = $u["name"];
          if(($name == $tempName) ||  ($email==$tempEmail)){
            $correct=0;
            break;
          }
        }
        
        if( $correct == 1) {
        $workingDB->insertUser($name, $email, $password);

        echo '<p class="success-message">Registration successful!</p>';
        header('Location: login.php');
        }
        else {
          echo '<p class="error-message">Used username or email</p>';
        }

      }
    ?>

    <form novalidate="novalidate" id="registration-form" action="" method="POST" onsubmit="event.preventDefault();">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <p class="error-message" id="name-error"></p>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <p class="error-message" id="email-error"></p>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <p class="error-message" id="password-error"></p>
      </div>

      <div class="form-group">
        <input type="submit" value="Register" class="btn btn-primary">
      </div>
      <a id="registeer-btn" href="login.php" >Login</a>
    </form>
  </div>
  <script src="js/registration.js"></script>
</body>
</html>