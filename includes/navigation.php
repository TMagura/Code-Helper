

   <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top mb-40" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            
                <a class="navbar-brand" href="index.php">CODE HELPER</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

            <?php 
            $query = "SELECT * FROM categories";
            $select_all_categories_query= mysqli_query($connection,$query);
            while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                $cat_id=$row['cat_id'];
               $cat_title= $row['cat_title'];

               ///// MAKE LINKS ACTIVE ////////
            $pageName = basename($_SERVER['PHP_SELF']);//this saves the actual page name
            $classCategory="";
            $registration="registration.php";
            $classRegistration="";
            $contactUs="contact.php";
            $classContactUs="";
            $classLogin="";
            $Login="login.php";

        if(isset($_GET['category']) && $_GET['category'] == $cat_id){
            $classCategory="active";
        }
        switch ($pageName) {
            case $registration:
            $classRegistration="active";
            break;
            case $contactUs:
                $classContactUs="active";
            break;
            case $Login:
                $classLogin="active";
            break;
            default:
            # code...
            break;
         }
// elseif ($pageName=$registration) {
//     $classRegistration="active";
// }elseif ($pageName=$contactUs) {
//     $classContactUs="active";
// }
      
     echo "<li class='{$classCategory}'><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>    
     ";
 }
         ?>               
            <?php if(isloggedIn()):?>

                <li>
                    <a href="admin/index.php">ADMIN</a>
                </li>
                <li class=" <?php echo $classContactUs;?>">
                    <a href="contact.php">Contact Us</a>
                </li>
                <li class=" <?php echo $classLogin;?>">
                <a href="includes/logout.php">Log Out</a>
                </li>
            <?php else: ?>

                <li class=" <?php echo $classRegistration;?>">
                    <a href="registration.php">Registration</a>
                </li>
                <li class=" <?php echo $classLogin;?>">
                    <a href="login.php">Log In</a>
                </li>

            <?php  endif;?>         
      <?php 
 

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] ==='admin'){
            if (isset($_GET['p_id'])) {
            $post_id=$_GET['p_id'];
            echo "
            <li>
            <a href='admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post</a>
            </li>
            ";
          }
        }
     ?>
                  
                    </li> 
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>