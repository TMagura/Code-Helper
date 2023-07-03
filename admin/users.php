<!-- header -->
<?php include "includes/Adheader.php";?>

<?php  
if (!is_admin($_SESSION['username'])) {
  header("Location:index.php ");
}
?>

    <div id="wrapper">

<!-- navigation -->
<?php include "includes/Adnavigation.php";?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 col-md-9">
                        <h1 class="page-header text-primary">
                            WELCOME TO ADMIN PANEL
                            <small class="text-warning"><?php echo $_SESSION['username'];?></small>
                        </h1>

                    </div>
                </div>
                <!-- /.row -->


<!-- this will call the view all post function -->
<?php 
if(isset($_GET['source'])){
$source=$_GET['source'];
}else{$source="";}
switch ($source) {
    case 'add_user' :
       include "includes/add_users.php" ;
        break;
    case 'edit_users':
        include "includes/edit_user.php" ;
        break;
    default:
        include "includes/view_all_users.php";
        break;
}
?>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>
