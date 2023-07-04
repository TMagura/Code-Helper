

 <?php
     if(ifItIsMethod('post')){
        if(isset($_POST['login'])){
            if(isset($_POST['username']) && isset($_POST['password'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            /////////// CLEAN THE DATA////////
            $username =mysqli_real_escape_string($connection,$username);
            $password =mysqli_real_escape_string($connection,$password);
            login_user($username,$password);
            }
          redirect('index.php');
        }
    }
?>


   <!-- Blog Sidebar Widgets Column -->
      <div class="col-md-4">
        <!-- Blog Search Well -->
        <div class="well">
    <?php if(isset($_SESSION['user_role'])):?>
        <h3>You are Logged in as : <span style="color:#B8860B; font-style: oblique"><?php echo strtoupper($_SESSION['username']);?> </span></h3>
            <a href="includes/logout.php" class="btn btn-primary">LOG OUT</a>
    <?php else:?>
        <h4 class="display-3">LOG IN</h4>
            <form action="" method ="post" class="form">
                <div class="form-group">
                    <label for="username"></label>
                    <input type="text" name="username" class="form-control" placeholder= 'Enter username'>
                </div>
                <div class="input-group">
                   <input type="password" name="password" class="form-control" placeholder= 'Enter password'>
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit" name="login">login</button>
                    </span>
                </div>
                <div class="form-group">
                    <a class="btn btn-light" href="forgot_password.php">Forgot Passsword</a>
                </div>
            </form> <!--form search end-->
    <?php endif;?>
                   
     <!-- /.input-group -->
    </div>


        <!-- Blog Search Well -->
        <div class="well">
            <h4>Search</h4>
            <form action="search.php" method ="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
            </form> <!--form search end-->
            <!-- /.input-group -->
        </div>



        <!-- Blog Categories Well -->
        <div class="well">
        <?php 
            $query = "SELECT * FROM categories ";
            $select_all_categories_query= mysqli_query($connection,$query);
         ?>     
                 <h4>Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php 
                                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                                    $cat_title= $row['cat_title'];
                                    $cat_id= $row['cat_id']; 
                                ?>
                                <li><a href="category.php?category=<?php echo $cat_id;?>"><?php echo $cat_title;?></a>
                                </li>
                                <?php    } ?>
                            </ul>
                            
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                   
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
 <?php  include "widget.php";?>

    </div>