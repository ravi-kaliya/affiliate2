<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: https://affiliate.traveliq.in/index.php");
   }
   
?>