<!-- header -->
<?php include "includes/Adheader.php";?>

<?php //include "functions.php";
ob_start();
?>
    <div id="wrapper">

<!-- navigation -->
<?php include "includes/Adnavigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            WELCOME TO ADMIN PANEL
                            <small class="text-warning"><?php echo $_SESSION['username'];?></small>
                        </h1>
<div class="col-xs-6">

<!-- FORM AND THE INSERT FUNCTION -->
<?php 
insert_categories();
?>
<form action="" method="post">
        <label for="cat_title"> Add Category</label>
    <div class="form-group">
        <input type="text" class="form-control" name="cat_title">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit" value="Add category">
    </div>
</form>

<!-- /////////THE UPDATE FUNCTION///////// -->
<?php 
if (isset($_GET['update'])) {
   $update_cat_id = $_GET['update']; 
   include "includes/update_cat.php";
}
?>
</div>

<!-- CATEGORY TABLE -->
<div class="col-xs-6">
<table class="table table-striped  table-hover">
    <thead>
        <tr>
            <th>ID </th>
            <th> Category Title</th>
            <th colspan ="2"> Action</th>
        </tr>
    </thead>
    <tbody>
<?php  select_all_categories();?>
<?php delete_categories();?>
    </tbody>
</table>

</div>
                        <!-- <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>
