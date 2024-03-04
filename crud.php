<!DOCTYPE html>
<html>
<head>
  <title>Dimitar Hristov project</title>
  <link rel="stylesheet" href="css/crud.css">
</head>
<body>
  <div class="container">
  <h1>CRUD</h1>
    <?php
      require_once 'manipulateDB.php';
      session_start();
      
      if ($_SESSION["id"] < 1) {
        header('Location: login.php');
      }
      
      $workingDB = new WorkingWithDB();
      $users = $workingDB->getUsers();
      echo '<h2>User email is:' .  $_SESSION["email"] . '</h2>';
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $correct=1;

        foreach($users as $u){
         $tempEmail = $u["email"];
         $tempName = $u["name"];
          if($_SESSION["userName"] !== $tempName && ($name == $tempName)){
            //echo '<p class="success-message">Update successful!</p>';
            $correct=0;
            break;
          }
        }
        
        if( $correct == 1) {
            $workingDB->updateUser($_SESSION["email"], $name, $password);


            echo '<p class="success-message">Update successful!</p>';
            //header('Location: crud.php');
        }
        else {
          echo '<p class="error-message">Update failed</p>';
          //header('Location: crud.php');
        }
        
      }
    ?>

    <form novalidate="novalidate" id="crud-form" action="" method="POST" onsubmit="event.preventDefault();">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <p class="error-message" id="name-error"></p>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <p class="error-message" id="password-error"></p>
      </div>

      <div class="form-group">
        <input type="submit" value="Update" class="btn btn-primary">
      </div>
      <a id="logout-btn" href="login.php" >Logout</a>
    </form>
  </div>
  <script src="js/crud.js"></script>
</body>
</html>