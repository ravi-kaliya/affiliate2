<?php


  if(isset( $_POST['register'])) {
    require('db.php');


    $aff_fullname = filter_var( $_POST["aff_fullname"], FILTER_SANITIZE_STRING );
    $aff_email = filter_var( $_POST["aff_email"], FILTER_SANITIZE_EMAIL);
    $aff_pas =  $_POST["aff_pass"];
    $caff_pas = $_POST["caff_pass"];
    $aff_mobile = filter_var( $_POST["aff_mobile"], FILTER_SANITIZE_STRING );
    $aff_pincode = filter_var( $_POST["aff_pincode"], FILTER_SANITIZE_STRING );
    $aff_state = filter_var( $_POST["aff_state"], FILTER_SANITIZE_STRING );
    $aff_city = filter_var( $_POST["aff_city"], FILTER_SANITIZE_STRING );
    $aff_address = filter_var( $_POST["aff_address"], FILTER_SANITIZE_STRING );
    $aff_accnumber = "";
    $aff_accname = "";
    $aff_ifsccode = "";
    $aff_pancard = "";
    // $aff_agentid = filter_var( $_POST["aff_agentid"], FILTER_SANITIZE_STRING );
    $aff_manualtime = date("l d-m-Y H:i:s");
    $aff_pass = base64_encode($aff_pas);
    $caff_pass = base64_encode($caff_pas);
    


      $stmtemail = $pdo -> prepare('SELECT * from user_details WHERE aff_email = ? ');
      $stmtemail -> execute([$aff_email]);
      $totalemail = $stmtemail -> rowCount();
      
      $stmtmobile = $pdo -> prepare('SELECT * from user_details WHERE aff_mobile = ? ');
      $stmtmobile -> execute([$aff_mobile]);
      $totalmobile = $stmtmobile -> rowCount();


      
      if( $totalemail <= 0 and $totalmobile <= 0 and $aff_pass===$caff_pass ) {


        
        
      //--------------------------------------------------------------------------------------

        echo "hello uid";

      $querychecklastid = "SELECT * FROM user_details ORDER BY aff_id DESC LIMIT 1";
      $checksqlquery = $pdo -> query($querychecklastid);
      
      if($row = $checksqlquery->fetch()){
              $uid = $row->aff_uid;
            //   $newuid = str_replace("TIQAFF","",$uid);
              $uid_incr = $uid+1;
              $fuid = str_pad($uid_incr, 5, 0, STR_PAD_LEFT);
            //   $uid_string = str_pad($uid_incr, 5, 0, STR_PAD_LEFT);
            //   $fuid = "TIQAFF".$uid_string;

      
                  $insertsql = 'INSERT into user_details(aff_fullname, aff_email, aff_pass, caff_pass, aff_mobile, aff_pincode, aff_state, aff_city, aff_address, aff_accnumber, aff_accname, aff_ifsccode, aff_pancard, aff_manualtime, aff_uid) VALUES(?, ?, ? , ?, ?, ? , ?, ?, ? , ?, ?, ? , ?,?,? ) ';
                  $stmt = $pdo -> prepare($insertsql);
                  $stmt -> execute( [ $aff_fullname, $aff_email, $aff_pass, $caff_pass, $aff_mobile, $aff_pincode, $aff_state, $aff_city, $aff_address, $aff_accnumber, $aff_accname, $aff_ifsccode, $aff_pancard, $aff_manualtime, $fuid] );
                  header('Location: https://affiliate.traveliq.in/login.php'); 

              if($resultQuery)
              {
                  echo " <br>New record added!<br>Name: ".$fuid;
              }
              else
              {
                  echo " No record added!<br>Try Again ";
              }
      }
      else{
          
          echo "hello uid1";

          $fuid = "10001";
              $insertsql = 'INSERT into user_details(aff_fullname, aff_email, aff_pass, caff_pass, aff_mobile, aff_pincode, aff_state, aff_city, aff_address, aff_accnumber, aff_accname, aff_ifsccode, aff_pancard, aff_manualtime, aff_uid) VALUES(? , ?, ?, ? , ?, ?, ? , ?, ?, ? , ?, ?, ? , ?,?,? ) ';
              $stmt = $pdo -> prepare($insertsql);
              $stmt -> execute( [ $aff_fullname, $aff_email, $aff_pass, $caff_pass, $aff_mobile, $aff_pincode, $aff_state, $aff_city, $aff_address, $aff_accnumber, $aff_accname, $aff_ifsccode, $aff_pancard, $aff_manualtime, $fuid] );
              header('Location: https://affiliate.traveliq.in/login.php'); 
          if($stmt)
          {
              echo "<br>New record added!<br>Name: ".$fuid;
          }
          else
          {
              echo " No record added!<br>Try Again ";
          }


      }



      // Mail Fir Start------------------------------------------------------------------------------------------------
      
      
                    $to = $aff_email; // change here
                    $subject = 'Affiliate Details of '.$aff_fullname; // change here
                    $from = 'support@traveliq.in'; // change here

                    // To send HTML mail, the Content-type header must be set
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    // Create email headers
                    $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                    
                    
                    // Compose a simple HTML email message
                    $message = 'Hi '.$aff_fullname.'!<br>';
                    $message .= '<br>Congratulations you have successfully submitted your IRCTC affiliate process with TraveliQ.<br> Get your affiliate dashboard details as mentioned below.<br>';
                    $message .= 'Affiliate Login Link: https://affiliate.traveliq.in/login.php<br>';
                    $message .= 'Affiliate Email: '.$aff_email.'<br>';
                    $message .= 'Affiliate Password: '.$aff_pas.'<br>';

            

     // Sending email
                if (mail($to, $subject, $message, $headers)) {
                    
                    header('Location: https://affiliate.traveliq.in/login.php');
                    exit();
                        
                }
                else{
                
                    echo 'Unable to send email. Please try again.';
                    
                }

    // Mail Fir End------------------------------------------------------------------------------------------------
        
        
        
    }
    else{


      if( $totalemail > 0 ) {
        // echo "Email already been taken <br>";
        
        $emailTaken = "<p class='container mt-1 p-1 rounded' style='background-color: red'>Email ID Registered</p>";         
      }
      else{
          $emailTaken = "<p class='container mt-1 p-1 rounded' style='background-color: green'>Email ID is Unique</p>";
      }




      if( $totalmobile > 0 ){

        $mobileTaken = "<p class='container mt-1 p-1 rounded' style='background-color: red'>Mobile number Aleady Exist</p>";

      }else
      {
        $mobileTaken = "<p class='container mt-1 p-1 rounded' style='background-color: green'>Mobile number is unique</p>";

      }


      if(!($aff_pass===$caff_pass))
        {
          $passTaken = "<p class='container mt-1 p-1 rounded' style='background-color: red'>Password Mismatch</p>";
        }
        else
        {
            $passTaken = "<p class='container mt-1 p-1 rounded' style='background-color: green'>Password Match</p>";
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
    <title>Affiliate Registration</title>
</head>
<body>
<div class="text-center container p-3">
<a class="text-center" href="https://affiliate.traveliq.in/index.php"><img src="asset/img/logo.png" alt="logo" width="100px" hight="100px"></a>
</div>
<div class="d-sm-flex justify-content-center align-items-center" style="height: 550px">

  <div class="container">
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
      <div class="card bg-light text-dark rounded mt-3">
          <div class="card-header"> <h3>Affliate Registration  </h3></div>
            <div class="card-body text-light p-5" style="background-color:#16407c">
            <form action="https://affiliate.traveliq.in/registration.php" method="POST">
              <div class="row">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_fullname"> Full Name </label>
                    <input required type="text" name="aff_fullname" value="<?php if(isset( $_POST['register'])) echo $aff_fullname?>" class="form-control" />
                  </div>
                </div>
                <div class="col-sm">
                <div class="form-group">
                    <label for="aff_email"> Email Address </label>
                    <input required type="email" name="aff_email" value="<?php if(isset( $_POST['register'])) echo $aff_email?>" class="form-control" />
                    <!-- <br /> -->
                    <?php if(isset($emailTaken)) { echo $emailTaken;} ?>
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_pass"> Enter your password </label>
                    <input required type="password" name="aff_pass" value="<?php if(isset( $_POST['register'])) echo $aff_pas?>" class="form-control" />

                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-group">
                    <label for="caff_pass"> Re-enter your password </label>
                    <input required type="password" name="caff_pass" value="<?php if(isset( $_POST['register'])) echo $caff_pas?>" class="form-control" />
                    <!-- <br /> -->
                    <?php if(isset($passTaken)) {echo $passTaken;}?>

                  </div>
                </div>
                <div class="col-sm">
                <div class="form-group">
                    <label for="aff_mobile"> Mobile Number </label>
                    <input required type="tel" name="aff_mobile" value="<?php if(isset( $_POST['register'])) echo $aff_mobile?>" class="form-control" />
                    <!-- <br /> -->
                    <?php if(isset($mobileTaken)) {echo $mobileTaken;}?>
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_pincode"> Pin Code </label>
                    <input required type="number" name="aff_pincode" value="<?php if(isset( $_POST['register'])) echo $aff_pincode?>" class="form-control" />
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_state"> State  </label>
                    <input required type="text" name="aff_state" value="<?php if(isset( $_POST['register'])) echo $aff_state?>" class="form-control" />
                    </br>
                  </div>
                </div>
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_city"> City  </label>
                    <input required type="text" name="aff_city" value="<?php if(isset( $_POST['register'])) echo $aff_city?>" class="form-control" />
                    </br>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm">
                  <div class="form-group">
                    <label for="aff_address"> Full Address </label>
                    <input required type="text" name="aff_address" value="<?php if(isset( $_POST['register'])) echo $aff_address?>" class="form-control" />
                    </br>
                  </div>
                </div>

              </div>

              <div class="row">
               
              <div class="row">
                <div class="col-sm">
                  <div class="form-group">
                    <button name="register" type="submit" class="btn text-light" style="background-color:#eb5228">Register</button>
                  </div>
                </div>
              </div>

              <br>
              <div class="container text-light p-1">
                <h6> Have an account? <a class="text-light" href="https://affiliate.traveliq.in/login.php">Login</a></h6>
              </div>


            </form>
            </div>

            <div class="col-sm-2"></div>
    </div>
  </div>





</div>
</div>



</body>
</html>
