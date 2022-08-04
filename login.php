<?php
  session_start();

  if(isset( $_POST['login'])) {
    require('db.php');
    
    $aff_email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL);
    $aff_pass = $_POST["password"];
    $aff_pass1 = base64_encode($aff_pass);
   

    $sql = 'SELECT * FROM user_details WHERE aff_email = ? AND aff_pass= ? LIMIT 1';
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([$aff_email,$aff_pass1]);
    $loginuser = $stmt -> fetch();
    // print_r($user);

    // $aff_passdb = $user->aff_pass;
    // echo $aff_pass1."<br>";

    if( isset($loginuser) ) {
      if($loginuser > 0 ) {
        echo "You have successfully logged in";
        $_SESSION['userId'] = $loginuser->aff_id;
        header('Location: http://localhost/affiliate2/index.php');
      } else {
        // echo "The login email or password is wrong";
        $wrongLogin = "The login email or password is wrong";
      }
    }
    // if( filter_var($userEmail, FILTER_VALIDATE_EMAIL) ) {
    //   $stmt = $pdo -> prepare('SELECT * from users WHERE email = ? ');
    //   $stmt -> execute([$userEmail]);
    //   $totalUsers = $stmt -> rowCount();

    //   // echo $totalUsers . '<br >';

    //   if( $totalUsers > 0 ) {
    //     // echo "Email already been taken <br>";
    //     $emailTaken = "Email already been taken";
    //   } else {
    //     $stmt = $pdo -> prepare('INSERT into users(name, email, password) VALUES(? , ?, ? ) ');
    //     $stmt -> execute( [ $userName, $userEmail, $passwordHashed] );
    //   }
    // }


    // echo $userName . " " . $userEmail . " " . $password;
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/img/favicon.png" rel="icon">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Affiliate Login</title>
</head>
<body>
<div class="text-center container p-3">
  <a class="text-center" href="https://localhost/affiliate.traveliq.in/index.php"><img src="asset/img/logo.png" alt="logo" width="100px" hight="100px"></a>
</div>
<div class="d-sm-flex justify-content-center align-items-center" style="height: 400px">


  <div class="container">
      <div class="row">
          <div class="col-sm"></div>
          <div class="col-sm">
                          
              <div class="container mt-3">
                  <div class="card" style="background-color:#16407c">
                  <div class="card-header bg-light mb-1"><h3>Affiliate Login</h3></div>
                  <div class="card-body p-4" >
                      <form action="login.php" method="POST">
                      <div class="form-group text-light">
                          <label for="email"> Email Address </label>
                          <input required type="email" name="email" placeholder="Enter your email or username" class="form-control"  />
                          <br />
                          
                      </div>
                      <div class="form-group text-light">
                          <label for="password"> Password </label>
                          <input required type="password" name="password" placeholder="Enter your password" autocomplete="off" class="form-control" />
                      </div>
                      <button name="login" type="submit" class="btn text-light mt-3" style="background-color:#eb5228">Login</button>
                      <br>
                      <?php if(isset($wrongLogin)) { ?>
                          <p class="p-2 mt-2 text-light bg-danger"><?php echo $wrongLogin ?></p>
                          <?php } ?>
                      </form>
                      <br>
                      <div class="container text-light p-1">
                        <h6> <a class="text-light" href="https://affiliate.traveliq.in/forget.php">Forget Password</a></h6>
                      </div>
                      <div class="container text-light p-1" style="background-color:#16407c">
                        <h6> Don't have an account? <a class="text-light" href="https://affiliate.traveliq.in/registration.php">Signup</a></h6>
                      </div>
                  </div>
                  </div>
              </div>
                  
              
          </div>
          <div class="col-sm"></div>
      </div>
  </div>
</div>
</body>
</html>




