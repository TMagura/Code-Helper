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
            <h2 class="page-header">PUBLISHED POSTS</h2>
              <?php 
////// COUNT PAGES FOR PAGINATION and the maths//////////
        if (isset($_GET['page'])) {
            $page= $_GET['page'];
             }else{$page= "";}

        if ($page=="" || $page==1) {
            $page_1 = 0;
            }else{
            $page_1 = ($page * 2)-2; 
        }

        if (isset($_SESSION['user_role']) && is_admin($_SESSION['username'])) {
            $query= "SELECT * FROM posts";
            $select_all_post= mysqli_query($connection,$query);
            $post_count= mysqli_num_rows($select_all_post);
            $post_count=ceil($post_count/2);
        }else{
            $query= "SELECT * FROM posts WHERE post_status ='published'";
            $select_all_post= mysqli_query($connection,$query);
            $post_count= mysqli_num_rows($select_all_post);
            $post_count=ceil($post_count/2);
        }

?>
            <?php
            /////DISPLAY POST ON HOME PAGE BASED ON WHO YOU ARE///////// 
            if (isset($_SESSION['user_role']) && is_admin($_SESSION['username'])) {
                $query = "SELECT * FROM posts  LIMIT $page_1,2 ";
            }else{
                $query = "SELECT * FROM posts WHERE post_status ='published' LIMIT $page_1,2 ";
            }

            $select_all_posts_query= mysqli_query($connection,$query);
            if (mysqli_num_rows($select_all_posts_query) < 1 ) {
                echo "<h2 class='text-center'>NO POSTS ARE PUBLISHED YET !!</h2>";
            }else {
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id= $row['post_id'];
                $post_title= $row['post_title'];
               $post_author= $row['post_author'];
               $post_date= $row['post_date'];
               $post_image= $row['post_image'];
               $post_content= $row['post_content'];
             ?>

      

                <!-- First Blog Post -->
                <h2>
                    Title Name:  <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo strtoupper($post_title);?></a>
                </h2>
                <p class="lead">
                   Written by <a href="author_posts.php?author=<?php echo $post_author;?>&p_id=<?php echo $post_id;?>"> <?php echo strtoupper($post_author);?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" width="200" height= "10" src="admin/images/<?php echo image_placeholder($post_image);?>" alt=" post picture"></a>
                <hr>
                <p><?php echo $post_content?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr><hr>
           <?php  } } ?>
               
                <hr>
                <!-- Pager -->
                <ul class="pager">
      <?php 

        /// loop to display all the pages///
            for ($i=1; $i <= $post_count; $i++) { 
                if($i==$page) {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                }else{
                    echo "<li><a style='background-color:#ff9999' href='index.php?page={$i}'>{$i}</a></li>";
                }
            
            }

        ?>

            </ul>
            </div>
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
    <?php include "includes/footer.php";?>
       