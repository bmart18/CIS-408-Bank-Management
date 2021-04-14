<?php
   session_start();

   //logout button
   if(session_destroy()) {
      header("Location: index.html");
   }
?>
