<?php 
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
if (isset($_GET['category'])) {
    $post_category_id=$_GET['category'];
}


///SECONDARY KEY IN ACTION BTWN POSTS AND CATEGORIES///////

/////DISPLAY POST ON HOME PAGE BASED ON WHO YOU ARE///////// 
    if (isset($_SESSION['user_role'])){
        $username= $_SESSION['username'];
    

    if(is_admin($username)) {
        
 
    //// using prepared statements: /////////
    $query1 = "SELECT post_id,post_title,post_author,post_date,post_image,post_content FROM posts WHERE post_category_id = ? ";
    $stmt1 = mysqli_prepare($connection,$query1);
    mysqli_stmt_bind_param($stmt1,"i",$post_category_id);//use i for integer and s for strings
    mysqli_stmt_execute($stmt1);//if its only insert or update this is the last 
    ///if selecting data from database////
    mysqli_stmt_bind_result($stmt1,$post_id,$post_title,$post_author,$post_date,$post_image,$post_content);

    mysqli_stmt_store_result($stmt1);//get rows number
    if (mysqli_stmt_num_rows($stmt1) < 1) {
        echo "<h2 class='text-center'>NO POSTS ARE PUBLISHED YET UNDER THIS CATEGORY !!</h2>";
    }
    $stmt_result=$stmt1; 
      }
    }

    else{

    $query2 = "SELECT post_id,post_title,post_author,post_date,post_image,post_content FROM posts WHERE post_category_id= ? AND post_status = ? ";
    $stmt2 = mysqli_prepare($connection,$query2);
    $published="published";///stmt does not take strings so make it a variable
    mysqli_stmt_bind_param($stmt2,"is",$post_category_id,$published);//use i for integer and s for strings
    mysqli_stmt_execute($stmt2);//if its only insert or update this is the last 
    ///if selecting data from database////
    mysqli_stmt_bind_result($stmt2,$post_id,$post_title,$post_author,$post_date,$post_image,$post_content);
    
    mysqli_stmt_store_result($stmt2);//help to get rows number
    if (mysqli_stmt_num_rows($stmt2) < 1) {
        echo "<h2 class='text-center'>NO POSTS ARE PUBLISHED YET UNDER THIS CATEGORY !!</h2>";
    }
    $stmt_result=$stmt2;

//$select_all_posts_query= mysqli_query($connection,$query);
}
while (mysqli_stmt_fetch($stmt_result)) {
  
    ?>

<h1 class="page-header">POSTS</h1>

        <!-- First Blog Post -->
        <h2>
            <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title?></a>
        </h2>
        <p class="lead">
            by <a href="index.php"><?php echo $post_author?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
        <hr>
        <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" width="200" height= "10" src="admin/images/<?php echo  image_placeholder($post_image);?>" alt=" post picture"></a>
        <hr>
        <p><?php echo $post_content?></p>
        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>


   <?php  } ?>
     
                <hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
        <?php include "includes/footer.php";?>
       