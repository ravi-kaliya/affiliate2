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




require_once 'db.php';

$userid = $_SESSION['userId'];


$stmtud = $pdo -> prepare('SELECT * from user_details WHERE aff_id = ? ');
$stmtud -> execute([$userid]);
if($user1 = $stmtud->fetch())
{
    $name = $user1->aff_fullname;
    $mobile = $user1->aff_mobile;
    $email = $user1->aff_email;
    $reffid = $user1->aff_uid;
    $afflink = "https://traveliq.in/irctc-agent-registration/?reffid=".$reffid;

    $perPage = 10;

    // Calculate Total pages
    $stmt = $pdo->prepare('SELECT count(*) FROM visitor WHERE aff_reffid = ?');
    $stmt -> execute([$reffid]);
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results / $perPage);
    

    // Current page
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $starting_limit = ($page - 1) * $perPage;

    // Query to fetch users
    $query = "SELECT * FROM visitor WHERE aff_reffid = $reffid ORDER BY aff_id DESC LIMIT $starting_limit,$perPage";

    // Fetch all users for current page
    $users = $pdo->query($query)->fetchAll();


}
else{
    $userd = "no details found";
}

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <script>
        function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        
        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
        }
</script>
    
    <title>Affiliate Dashboard</title>
</head>
<body>
<div class="text-center container p-3">
    <a class="text-center" href="https://affiliate.traveliq.in/index.php"><img src="asset/img/logo.png" alt="logo" width="100px" hight="100px"></a>
</div>

<div class="container-sm mt-2">
    <div class="card text-light rounded" style="background-color:#16407c">
        <div class="card-header text-center m-2"> 
            <div class="d-sm-flex justify-content-between">
                <div class="p-2 m-2 bg-light text-dark rounded">Hi <?php  echo $name; ?></div>
                <div class="p-2">Affiliate Dashboard </div>
                <div class="px-4 py-2 m-2 rounded" style="background-color:#eb5228">Affiliate ID: <?php  echo $reffid; ?></div>
            </div>

        </div>

        <div class="card-body bg-light text-light">


            <div class="d-sm-flex align-content-start">
                <div class="nav justify-content-start flex-column nav-pills p-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-Profile4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Profile4" type="button" role="tab" aria-controls="v-pills-Profile4" aria-selected="true">Profile</button>
                    <button class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="false">Clicks</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Closed</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Payout</button>
                </div>
                <div class="tab-content d-sm-flex flex-fill m-1 px-3 border rounded" id="v-pills-tabContent">

                    <!-- 1st Tab -->

                    <div class="tab-pane fade show active flex-fill" id="v-pills-Profile4" role="tabpanel" aria-labelledby="v-pills-Profile4-tab">

                    
                        <div class="mt-3 align-content-start">
                            <div class="row">
                                <div class="col-lg-3 p-sm-1 text-dark text-center"><h5>Your Affiliate Link</h5></div>
                                <div class="col-lg-6 p-sm-1 py-1">
                                        <input required type="text" name="affiliatelink" value="<?php echo $afflink;?>" id="myInput" class="form-control" disabled />
                          
                                </div>
                                <div class="col-lg-3 p-sm-1 text-center">
                                     <button name="copyaffiliateid" type="submit" class="btn text-light" onclick="myFunction()" style="background-color:#eb5228;"><i class="bi bi-clipboard-check-fill"></i> Copy your affiliate link</button>
                                </div>
                            </div>
                            <div class=" text-center my-3 text-dark"> 
                                <h3><?php echo $name;?> Profile</h3>
                            </div>
                            <form action="https://affiliate.traveliq.in/update.profile.php" method="POST">
                            <!-- <div style="overflow-x:auto;"> -->
                                <div class="row text-center py-2">
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Name</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col" >
                                                <?php echo $name;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Email ID</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <?php echo $email;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Mobile Number</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <?php echo $mobile;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Affiliate Link</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <a href="<?php echo $afflink;?>" class="color-light" target="_blank" rel="noopener noreferrer">Visit</a>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Pin Code</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                
                                                <div class="form-group">
                                                   <input required type="tel" name="aff_pincode" value="<?php echo $user1->aff_pincode;?>" class="form-control" />
                                                </div>

                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>State</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_state" value="<?php echo $user1->aff_state;?>" class="form-control" />
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>City</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_city" value="<?php echo $user1->aff_city;?>" class="form-control" />
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Full Address</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center  p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_address" value="<?php echo $user1->aff_address;?>" class="form-control" />
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Account Number</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_accnumber" value="<?php echo $user1->aff_accnumber;?>" class="form-control" />
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Account Holder Name</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_accname" value=" <?php echo $user1->aff_accname;?>" class="form-control" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>IFSC Code</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_ifsccode" value=" <?php echo $user1->aff_ifsccode;?>" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-1 text-dark ">
                                        <div class="row text-center p-2 m-1 border" style="background-color:#eb5228">
                                            <div class="col text-light">
                                                <h6>Pan Number</h6>
                                            </div>
                                        </div>
                                        <div class="row text-center p-2 m-1 border" style="color:#16407c">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input required type="text" name="aff_pancard" value="<?php echo $user1->aff_pancard;?>" class="form-control" />
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="d-sm-flex justify-content-end">
                                    <div class="row">
                                        <div class="col-sm-12 p-1 text-dark"></div>
                                        <div class="col-sm-12 p-1 text-dark"></div>
                                        <div class="col-sm-12 p-1">
                                        <a href="http://localhost/affiliate2/update-profile.php" rel="noopener noreferrer"><button name="copyaffiliateid" type="submit" class="btn text-light" style="background-color:#16407c;"><i class="bi bi-cloud-arrow-up"></i> Update Profile</button></a>
                                        </div>
                                    </div>


                            
                            </div>
                            <form>
                                <!-- <table class="table table-responsive-sm table-bordered text-center rounded">
                                    <thead class="pt-5 text-dark bg-warning rounded">
                                    
                                        <tr>
                                            <th>Name</th>
                                            <th>Email ID</th>
                                            <th>Mobile Number</th>
                                            <th>Affiliate Link</th>
                                            
                                        </tr>

                                    </thead>
                                    <tbody id="tbody">
                                                                            
                                        <tr class="bg-dark text-light">
                                            <td> <?php echo $name;?></td>

                                            <td> <?php echo $email; ?> </td>
                                            <td> <?php echo $mobile;?> </td>
                                            <td> <a href="<?php echo $afflink;?>" target="_blank" class="text-light">Visit</a> </td>


                                            
                                        </tr>


                                            
                                    
                                    </tbody>

                                </table> -->
                            <!-- </div> -->

                            
                        </div>

                    </div>                    


                    <!-- 2nd Tab -->
                                    
                    <div class="tab-pane fade flex-fill" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                        <div class="mt-3">
                            <div class=" text-center my-3 text-dark"> 
                                <h3><?php  echo $name; ?> Total Closed</h3>
                            </div>
                            

                            
                        </div>

                    </div>
                    <!-- 3nd Tab -->

                    <div class="tab-pane fade flex-fill" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        
                    <div class="mt-3">
                            <div class=" text-center my-3 text-dark"> 
                                <h3><?php echo $name;?> Total Payout</h3>
                            </div>
                            
                            
                        </div>

                    </div>
                    <!-- 4th Tab -->
                    
                    <div class="tab-pane fade flex-fill" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">



                            
                        <div class="container">

                            <div class="row p-2">
                                <div class="col-lg-4 col-sm-12 p-3 rounded"></div>
                                <div class="col-lg-4 col-sm-12 p-3 text-white text-center rounded" style="background-color:#16407c"><h3>Total Clicks</h3><br>

                                    <div class="">

                                                                                
                                        <ul class="pagination justify-content-center">

                                            <li class="page-item links"><a class="page-link text-light" style="background-color:#eb5228" ><b><?php  echo $total_results; ?></b></a></li>

                                            </li>
                                        </ul>


                                    </div>

                                </div>
                                <div class="col-lg-4 col-sm-12 p-3 rounded"></div>

                            </div>
                        </div>
                            
                            
                    </div>


                
                </div>
            </div>




 




        </div>



    

        <div class="container d-flex justify-content-end p-1">
            <form method="POST">
                <div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                
                                <button class="btn px-5 py-2 text-light" style="background-color:#eb5228" name="logout">Logout</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>          
        </div>
    </div>
</div>





</body>
</html>