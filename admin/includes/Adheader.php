<!-- Ob_start used wen redirecting using the header function -->
<?php ob_start();?>
<?php include "../includes/db.php";?>
<?php include "functions.php";  session_start(); ?>

      <?php 
      ////////// CHECK TO SEE IF THE USER IS AN ADMIN B4 ADMIN PAGE////////

        if(isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] !== 'admin' ) {
              header("Location:../index.php");
            }
          }else {
            header("Location:../index.php");
        }

      ?>
<!DOCTYPE html>
  <html lang="en">
      <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Code Helper</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

      </head>
<body>