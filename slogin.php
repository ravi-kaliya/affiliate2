<?php
  session_start();
   
  if(!isset($_SESSION['userId'])) 
        {

            header("location: https://affiliate.traveliq.in/login.php");
        }  
               
        if( isset($_POST['logout'])) {
            session_destroy();
            header("location: https://affiliate.traveliq.in/login.php");
          }
          
    include 'db.php';
    $uid = $_SESSION['userId'];
    $sql = 'SELECT * FROM user_details WHERE aff_id = ? LIMIT 1';
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([$uid]);
    $loginuser = $stmt -> fetch();
    echo "<pre>";
    $affiliateid = $loginuser->aff_uid;
    echo "</pre>";
$pdo = null;

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
    <title>Welcome Login</title>
</head>
<body>

<div class="text-center container p-3">
<a class="text-center" href="https://localhost/affiliate.traveliq.in/index.php"><img src="asset/img/logo.png" alt="logo" width="100px" hight="100px"></a>
</div>

    <div class="container">
        <div class="card bg-dark text-light rounded mt-5">
            <div class="card-header text-center m-3"> <h1>Welcome to Affliate Dashboard: <?php echo $affiliateid;?></h1>

                <ul class="nav justify-content-center m-2 p-2">
                    <li class="nav-item">
                    <a class="nav-link" href="https://affiliate.traveliq.in/index.php"><button class="btn btn-warning" name="logout">Total Click</button></a>
                    </li>

                </ul>


            </div>
            <div class="card-body bg-light text-light">

                <div class="d-flex align-items-center justify-content-center m-5" style="height: 300px;">


                    <div class="container mx-3 my-3">
                        <div class="row m-5">
                        <div onclick="location.href='https://affiliate.traveliq.in/index.php';" class="col p-5 m-2 bg-success text-white text-center rounded"><h4> Click</h4></div>
                        <div class="col p-5 m-2 bg-info text-white text-center rounded"><h4>Payment</h4></div>
                        <div class="col p-5 m-2 bg-danger text-white text-center rounded"><h4>Closer</h4></div>

                    </div>
                </div>

             

 


            </div>  



        </div>

        <div class="container d-flex justify-content-center p-3">
            <form method="POST">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                
                                        <button class="btn btn-primary" name="logout">Logout</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>          
        </div>






</body>
</html>