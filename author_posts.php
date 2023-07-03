<?php 
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";
//include "admin/functions.php";
ob_start();
?>



    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            if (isset($_GET['p_id'])) {
               $link_post_id= $_GET['p_id'];
               $link_post_author= $_GET['author'];
            }
            $query = "SELECT * FROM posts WHERE post_author = '{$link_post_author}' ";
            $select_all_posts_query= mysqli_query($connection,$query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_author_id= $row['post_id'];
               $post_title= $row['post_title'];
               $post_author= $row['post_author'];
               $post_date= $row['post_date'];
               $post_image= $row['post_image'];
               $post_content= $row['post_content'];
             ?>

<h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                <a href="post.php?p_id=<?php echo $post_author_id;?>"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    Written By <strong><?php echo $post_author;?></strong>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date;?></p>
                <hr>
                <img class="img-responsive" width="200" height= "10" src="admin/images/<?php echo $post_image;?>" alt=" post picture">
                <hr>
                <p><?php echo $post_content;?></p>
                


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



                <!-- Blog Comments -->





                <!-- Comments Form -->


                <hr>

</div>

<?php include "includes/sidebar.php";?>

</div>
<!-- /.row -->
            </div>  
        <hr>
        <?php include "includes/footer.php";?>