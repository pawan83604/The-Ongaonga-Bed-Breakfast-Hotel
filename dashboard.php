
   <?php
   session_start();

   // Check if the user is logged in
   if (!isset($_SESSION["username"])) {
       header("Location: login.php");
       exit();
   }
   ?>

   <!DOCTYPE html>
   <html>
   <head>
       <title>Dashboard</title>
   </head>
   <body>
       <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
     
   </body>
   </html>
