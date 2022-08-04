<?php

  if(isset( $_POST['forget'])) {
    require('db.php');
    
    $aff_email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL);

   

    $sql = 'SELECT * FROM user_details WHERE aff_email = ? LIMIT 1';
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([$aff_email]);
    $loginuser = $stmt -> fetch();
    



    if( isset($loginuser) ) {
      if($loginuser > 0 ) {
        
        $forget_pass = $loginuser->aff_pass;
        $forget_email = $loginuser->aff_email;
        $forget_fullname = $loginuser->aff_fullname;
        $forget_pass = base64_decode($forget_pass);
        echo $forget_pass;
        
    //     // Mail to user
    //           // Mail Fir Start------------------------------------------------------------------------------------------------
      
      
    //                 $to = $forget_email; // change here
    //                 $subject = 'Affiliate Details of '.$forget_fullname; // change here
    //                 $from = 'support@traveliq.in'; // change here

    //                 // To send HTML mail, the Content-type header must be set
    //                 $headers  = 'MIME-Version: 1.0' . "\r\n";
    //                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //                 // Create email headers
    //                 $headers .= 'From: '.$from."\r\n".
    //                 'Reply-To: '.$from."\r\n" .
    //                 'X-Mailer: PHP/' . phpversion();
                    
                    
    //                 // Compose a simple HTML email message
    //                 $message = 'Hi '.$forget_fullname.'!<br>';
    //                 $message .= '<br>As per your requirement, Find below the login details<br>';
    //                 $message .= 'Affiliate Login Link: https://affiliate.traveliq.in/login.php<br>';
    //                 $message .= 'Affiliate Email: '.$forget_email.'<br>';
    //                 $message .= 'Affiliate Password: '.$forget_pass.'<br>';

            

    //  // Sending email
    //                 if (mail($to, $subject, $message, $headers)) {
                    
    //                 header('Location: https://affiliate.traveliq.in/login.php');
    //                 exit();
    //             } else {
    //             echo 'Unable to send email. Please try again.';
    //         }

    // // Mail Fir End------------------------------------------------------------------------------------------------
        
        
        
        // header('Location: https://affiliate.traveliq.in/slogin.php');
      } else {
          
          // Show error
          
        $wrongemail = "Ooh login mail is not valid.";
      }
    }

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
    <title>Affiliate Forget Password</title>
</head>
<body>
<div class="text-center container p-3">
    <a class="text-center" href="https://affiliate.traveliq.in/index.php"><img src="asset/img/logo.png" alt="logo" width="100px" hight="100px"></a>
</div>
<div class="d-sm-flex justify-content-center align-items-center" style="height: 300px">


    <div class="container">
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm">
                            
                <div class="container mt-3">
                    <div class="card" style="background-color:#16407c">
                    <div class="card-header bg-light mb-1"><h3>Affiliate Forget Password</h3></div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                        <div class="form-group text-light">
                            <label for="email"> Email Address </label>
                            <input required type="email" name="email" placeholder="Enter your email or username" class="form-control"  />
                        </div>

                        <button name="forget" type="submit" class="btn mt-3 text-light" style="background-color:#eb5228">Send Link</button>
                        <br>
                        <br>
                        <?php if(isset($wrongLogin)) { ?>
                            <p class="p-2 mt-2 text-light bg-danger"><?php echo $wrongLogin ?></p>
                            <?php } ?>
                        </form>
                        
                        <div class="container text-light p-1">
                        <h6> Have an account? <a class="text-light" href="https://affiliate.traveliq.in/login.php">Login</a></h6>
                        </div>
                        <div class="container text-light p-1">
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




