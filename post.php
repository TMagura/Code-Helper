
<?php 
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";
//include "admin/functions.php";
ob_start();
?>
<?php 
   if (isset($_SESSION['user_id'])) {
    $session_user_id = $_SESSION['user_id'];
////***code for Likes (Liking)****//////
if (isset($_POST['liked']) && isset($_SESSION['user_id'])) {
    
    $script_post_id = $_POST['post_script_id'];
    $script_user_id = $_POST['user_script_id'];
//1. SELECT post
$query= "SELECT * FROM posts WHERE post_id=$script_post_id";
$select_post= mysqli_query($connection,$query);
$posts=mysqli_fetch_array($select_post);
$likes=$posts['likes'];

//2. UPDATE post with likes
mysqli_query($connection,"UPDATE posts SET likes = $likes+1 WHERE post_id = $script_post_id");

//3. CREATE likes for post
mysqli_query($connection,"INSERT INTO likes (post_id , user_id) VALUES ($script_post_id,$script_user_id)");
exit();
 }


////***code for Likes (UnLiking)****//////
if (isset($_POST['Unliked']) && isset($_SESSION['user_id'])) {
    $script_post_id = $_POST['post_script_id'];
    $script_user_id = $_POST['user_script_id'];
//1. SELECT post
$query= "SELECT * FROM posts WHERE post_id=$script_post_id";
$select_post= mysqli_query($connection,$query);
$posts=mysqli_fetch_array($select_post);
$likes=$posts['likes'];

//2. UPDATE post with likes
mysqli_query($connection,"UPDATE posts SET likes = $likes-1 WHERE post_id = $script_post_id");

//3. DELETE likes for table LIKES
mysqli_query($connection,"DELETE FROM likes WHERE user_id = $script_user_id AND post_id = $script_post_id ");
exit();
 }
   }
?> 


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            if (isset($_GET['p_id'])) {
               $link_post_id= $_GET['p_id'];

               /// COUNTING VIEWS QUERY/////
            $view_query="UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id= $link_post_id ";   
            $view_count_query= mysqli_query($connection,$view_query);
            confirm_query($view_count_query);

            /////DISPLAY POST ON HOME PAGE BASED ON WHO YOU ARE///////// 
    if (isset($_SESSION['username']) && is_admin($_SESSION['username'])) {
        $query = "SELECT * FROM posts WHERE post_id={$link_post_id}";
    }else{
        $query = "SELECT * FROM posts WHERE post_id={$link_post_id} AND post_status ='published' ";
    }

            $select_all_posts_query= mysqli_query($connection,$query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
               $post_title= $row['post_title'];
               $post_author= $row['post_author'];
               $post_date= $row['post_date'];
               $post_image= $row['post_image'];
               $post_content= $row['post_content'];
             ?>

<h1 class="page-header">POSTS</h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author;?>&p_id=<?php echo $link_post_id;?>"><?php echo $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                <hr>
                <img class="img-responsive" width="200" height= "10" src="admin/images/<?php echo image_placeholder($post_image);?>" alt=" post picture">
                <hr>
                <p><?php echo $post_content?></p>

                

   <?php 
        if(isset($_SESSION['user_role']) ){
            if(DoesUserLikedThisPost($link_post_id,$session_user_id)){
        echo ' 
        <div class="row">
        <p class="pull-right"><a class="Unlike" href="" data-toggle="tooltip" title="You liked it before!"><span class="glyphicon glyphicon-thumbs-down"></span> UnLike</a></p>  
        </div>';
        }else {
        echo '
        <div class="row">
        <p class="pull-right"><a class="like" href="" data-toggle="tooltip" title="Click and like!"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></p>  
        </div>';
        }
    }else { 
    echo '
    <div class="row">
    <p class="pull-right"><a href="login.php">login to pass a Like</a></p>  
    </div>';
      }
    ?> 

        <div class="row">
             <span class="pull-right">Likes:<?php echo numberOfLikes($link_post_id);?></span> 
       </div>

           <?php    }
           }else {
            header("Location:index.php");
           }
           
           
           ?>

               
                <hr>

                <!-- Pager -->
                <!-- <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul> -->



                <!-- Blog Comments -->


<?php 
//////// CREATE COMMENTS BASED ON THE POST_ID//////// 
if (isset($_POST['create_comment'])) {
  $the_post_id = $_GET['p_id'];
  $comment_author = $_POST['comment_author'];
  $comment_email = $_POST['comment_email'];
  $comment_content = $_POST['comment_content'];
  $comment_date = date('d-m-y');
  if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content) && !empty($comment_date)) {
 
  $query= "INSERT INTO comments (comment_post_id,comment_author,comment_email,comment_content,comment_date,comment_status) VALUES ('{$the_post_id}','{$comment_author}','{$comment_email}','{$comment_content}',now(),'approved')";
  $create_comment_query= mysqli_query($connection,$query);
 confirm_query($create_comment_query);


 //// Can use this code also to add comment count
// $comment_query="UPDATE posts SET post_comment_count = post_comment_count+1 WHERE post_id={$the_post_id}";
// $update_comment_count=mysqli_query($connection,$comment_query);
// header("Location:post.php?p_id=$link_post_id");
}else{
echo "<script>alert('the fields cannot be empty')</script>";
}
}


?>




                <hr>
                
                <!-- Posted Comments -->

<h3 class="font-weight-bolder">COMMENTS</h3>
<?php 
/////////// DISPLAY ALL COMMENTS RELATED THE POST/////////
if (isset($_GET['p_id'])) {
$link_post_id= $_GET['p_id'];
$query = "SELECT * FROM comments WHERE comment_post_id={$link_post_id} AND comment_status='approved' ORDER BY comment_id DESC " ;
$select_all_comments_query= mysqli_query($connection,$query);
confirm_query($select_all_comments_query);
if (mysqli_num_rows($select_all_comments_query) < 1 ) {
    echo "NO COMMENTS UNDER THAT POST YET!!";
}
while ($row = mysqli_fetch_assoc($select_all_comments_query)) { 
$comment_author= $row['comment_author'];
$comment_email= $row['comment_email'];
$comment_content= $row['comment_content'];
$comment_date= $row['comment_date'];
$sub_comment_content=substr($comment_content,0,20);

?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img width="64" class="media-object" src=" admin/images/<?php echo image_placeholder($post_image);?>" alt="post picture">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date;?></small>
                        </h4>
                        <p><?php echo $comment_content;?></p>
                    </div>
                </div>
<?php }}?>
<br><br><hr>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                    <div class="form-group">
                            <input class="form-control" type="text" name="comment_author" placeholder="Your Username">
                        </div>
                    <div class="form-group">
                            <input class="form-control" type="email" name="comment_email" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Type comment in here" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

</div>

<?php include "includes/sidebar.php";?>

</div>
<!-- /.row -->
            </div>  
        <hr>
        <?php include "includes/footer.php";?>

<script>
$(document).ready(function(){
  var post_id= <?php echo $link_post_id;?>;
  var user_id= <?php echo $session_user_id;?>;

 ///Liking a post
        $('.like').click(function(){
        $.ajax({
            url: "post.php?p_id=<?php echo $link_post_id;?>",
            type: 'post',
            data: {
                'liked':1,
                'post_script_id':post_id,
                'user_script_id':user_id
            }

            });
        });
  //// UnLiking a post
  $('.Unlike').click(function(){
        $.ajax({
            url: "post.php?p_id=<?php echo $link_post_id;?>",
            type: 'post',
            data: {
                'Unliked':1,
                'post_script_id':post_id,
                'user_script_id':user_id
            }

            });
        });
        $('[data-toggle="tooltip"]').tooltip();  
    });

</script>