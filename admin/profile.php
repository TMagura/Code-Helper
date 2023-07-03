<!-- header -->
<?php include "includes/Adheader.php";?>
<?php //include "functions.php";?>
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
                    <small class="text-warning"><?php echo strtoupper($_SESSION['username']);?></small>
                </h1>

<?php 
    if (isset($_SESSION['username'])) {
        $username_profile = $_SESSION['username'];
        }
            $query = "SELECT * FROM users WHERE username = '{$username_profile}'" ;
            $select_all_users_query= mysqli_query($connection,$query);
            confirm_query($select_all_users_query);
            while ($row = mysqli_fetch_assoc($select_all_users_query)) { 
            $user_id        = $row['user_id'];
            $username       = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname  = $row['user_lastname'];
            $user_password  = $row['user_password'];
            $user_image     = $row['user_image'];
            $user_email     = $row['user_email'];
            $user_role      = $row['user_role'];
       }

        //////////////UPDATE POSTS /////////////////////
        if (isset($_POST['update_profile'])) {
            $username      = $_POST['username'];
            $user_password = $_POST['user_password'];
            $user_firstname= $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $user_email    = $_POST['user_email'];
            $user_role     = $_POST['user_role'];

      //////dealing with the image function////////
    $user_image= $_FILES['user_image']['name'];
    $user_image_temp= $_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp,"images/$user_image");


     //////////keep image even if we update and leave out the image/////////
        if(empty($user_image)){
            $query= "SELECT * FROM users WHERE username = '{$username_profile}'";
            $select_image = mysqli_query($connection,$query);
            while($row=mysqli_fetch_assoc($select_image)){
            $user_image=$row['user_image'];
            }
        } 
    ///////get the randsalt from the db to update//////////
    $query= "SELECT randsalt FROM users";
    $get_randsalt_query=mysqli_query($connection,$query);

    if(!$get_randsalt_query){
        die("QUERY FAILED".mysqli_error($connection));
    }
    /// we can not use the while loop if we want one thing ////
        $row = mysqli_fetch_array($get_randsalt_query);
        $randsalt = $row['randsalt'];
        $hashed_password = crypt($user_password, $randsalt);

///////////UPDATE QUERY FOR POST////////////////
      
    $query= "UPDATE users SET "; 
    $query.="username= '{$username}',";
    $query.="user_password= '{$hashed_password}',";
    $query.="user_firstname= '{$user_firstname}',";
    $query.="user_lastname= '{$user_lastname}',";
    $query.="user_email= '{$user_email}',";
    $query.="user_role= '{$user_role}',";
    $query.="user_image= '{$user_image}'";
    $query.="WHERE user_id= {$user_id}" ;

    $query_update_users= mysqli_query($connection,$query);
    if(!confirm_query($query_update_users)){
    echo '  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Profile updated successfully <a class="text-primary" href="index.php">/Go back to admin</a>.
    </div>'; 
     }
    }
  ?>

    <div class="row">
      <div class="col-lg-12">
        <form  class= "form" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Firstname</label>
            <input type="text" class="form-control" value='<?php echo $user_firstname ;?>' name="user_firstname" required>
        </div>
        <div class="form-group">
            <label for="title">Lastname</label>
            <input type="text" class="form-control" value='<?php echo $user_lastname ;?>' name="user_lastname" required>
        </div>
        <div class="form-group">
            <label for="title">Username</label>
            <input type="text" class="form-control" value='<?php echo $username ;?>' name="username"  required>
        </div>
        <div class="form-group">
            <label for="title">Password</label>
            <input type="password" class="form-control" placeholder="please enter password" name="user_password" required>
        </div>
       <div class="form-group">
            <label for="title">Email</label>
            <input type="email" class="form-control" value='<?php echo $user_email ;?>' name="user_email" required>
       </div>
        <div class="form-group">
            <label for="post_category_id">Role</label>   
            <select class="form-control" name="user_role">
            <option value='<?php echo $user_role;?>' selected><?php echo $user_role;?></option>";

                <?php 
                ///////// GET ROLE VALUES FOR SELECT OPTION/////////////////
                if($user_role=='admin'){
                echo "<option value='subscriber'>subscriber</option>";
                }else{
                    echo "<option value='admin'>admin</option>";
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="user_image">User Image</label><br>
                <img src="images/<?php echo $user_image;?>" alt="image from database" width="70" height= "50">
                <input type="file" class="form-control" name="user_image">
            </div>  
            <div class="form-group">
                <input class="btn btn-primary" type="submit" class="form-control" name="update_profile" value="Update Profile">
            </div>
        </form>
    </div>
</div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>
