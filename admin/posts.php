<!-- header -->
<?php include "includes/Adheader.php";?>

    <div id="wrapper">

<!-- navigation -->
<?php include "includes/Adnavigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
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
    case 'add_post' :
       include "includes/add_posts.php" ;
        break;
    case 'edit_post':
        include "includes/edit_posts.php" ;
        break;
    default:
        include "includes/view_all_posts.php";
        break;
}
?>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>
