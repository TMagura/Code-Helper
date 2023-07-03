<?php //include "functions.php";
 ob_start(); ?>
<?php 
if (isset($_GET['p_id'])) {
$edit_post_id= $_GET['p_id'];
}
$query = "SELECT * FROM posts WHERE post_id= {$edit_post_id}" ;
$select_all_posts_query= mysqli_query($connection,$query);
while ($row = mysqli_fetch_assoc($select_all_posts_query)) { 
$post_id= $row['post_id'];
// $post_users_id= $row['post_user_id'];
$post_title= $row['post_title'];
$post_category_id= $row['post_category_id'];
$post_status= $row['post_status'];
$post_image= $row['post_image'];
$post_content= $row['post_content'];
$post_tags= $row['post_tags'];
$post_comment_count= $row['post_comment_count'];
$post_date= $row['post_date'];
}
//////////////UPDATE POSTS /////////////////////
if (isset($_POST['update_post'])) {

    if (isset($_SESSION['username'])) {
        $username=$_SESSION['username'];
    }
    $query_author = "SELECT * FROM users WHERE username= '{$username}'";
    $users_query_author = mysqli_query($connection,$query_author);
    confirm_query($users_query_author);
    while($row = mysqli_fetch_assoc($users_query_author)){
    $post_users_id = $row['user_id'];
    $username= $row['username'];}

    //$post_user_id= $_POST['post_user_id'];
    $post_title= $_POST['post_title'];
    $post_content= $_POST['post_content'];
    $post_category_id= $_POST['post_category_id'];
    $post_status= $_POST['post_status'];
    $post_tags= $_POST['post_tags'];


////////dealing with the date function////////////
    $post_date= date('d-m-y');

///////////dealing with the image function////////
    $post_image= $_FILES['post_image']['name'];
    $post_image_temp= $_FILES['post_image']['tmp_name'];
    move_uploaded_file($post_image_temp,"images/$post_image");


     //////////keep image even if we update and leave out the image/////////
if(empty($post_image)){
    $query= "SELECT * FROM posts WHERE post_id={$edit_post_id}";
    $select_image=mysqli_query($connection,$query);
    while($row=mysqli_fetch_assoc($select_image)){
      $post_image=$row['post_image'];
    }
}

///////////UPDATE QUERY FOR POST////////////////
      
    $query= "UPDATE posts SET "; 
    $query.="post_title= '{$post_title}',";
    $query.="post_category_id= '{$post_category_id}',";
    $query.="post_date= now(),";
    $query.="post_user_id= '{$post_users_id}',";
    $query.="post_status= '{$post_status}',";
    $query.="post_tags= '{$post_tags}',";
    $query.="post_content= '{$post_content}',";
    $query.="post_image= '{$post_image}'";
    $query.="WHERE post_id= {$edit_post_id}" ;

    $query_update_posts= mysqli_query($connection,$query);
    confirm_query($query_update_posts);
  echo "
  <div class='alert alert-success alert-dismissible'>
  <button type='button' class='close' data-dismiss='alert'>&times;</button>
  <strong>Post successfully updated  :click to <a href='../post.php?p_id=$edit_post_id'>view post</a> or <a href='posts.php'>view all posts</a></strong>
</div>
  ";
}
?>

<div class="row">
<div class="col-lg-12">
<form  class= "form" action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="title">Post title</label>
    <input value= "<?php echo $post_title;?>" type="text" class="form-control" name="post_title">
</div>
<div class="form-group">
<label for="post_category_id">Category</label>   
<select class="form-control" name="post_category_id">
<?php 
 
///////// GET CATEGORY VALUES FOR SELECT OPTION/////////////////

$query = "SELECT * FROM categories";
$categories_query = mysqli_query($connection,$query);
confirm_query($categories_query);
while ($row = mysqli_fetch_assoc($categories_query)) {
$cat_title = $row['cat_title']; 
$cat_id= $row['cat_id'];
if($cat_id==$post_category_id){
    echo "<option value='{$cat_id}' selected >{$cat_title}</option>";
}else{
    echo "<option value='{$cat_id}'>{$cat_title}</option>";
}

 }

?>
</select>
</div>


<div class="form-group">
<label for="post_user_id">Author</label>   
<select class="form-control" name="">
<?php 
 //this below will be used wen user is admin is allowed to edit his posts only
///////// GET user VALUES FOR SELECT OPTION/////////////////
if (isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
}
$query_author = "SELECT * FROM users WHERE username= '{$username}'";
$users_query_author = mysqli_query($connection,$query_author);
confirm_query($users_query_author);
while($row = mysqli_fetch_assoc($users_query_author)){
$post_users_id = $row['user_id'];
$username= $row['username'];}
echo "<option value='{$post_users_id}' selected disabled></option>";

?>
</select>
</div>

<div class="form-group">
    <label for="post_date">Post Date</label>
    <input type="date" name="post_date">
</div>

<div class="form-group">
    <label for="post_status">Post status</label>   
<select class="form-control" name="post_status">
<option value='<?php echo strtolower($post_status);?>' selected><?php echo $post_status;?></option>";

<?php 
///////// GET Posts VALUES FOR SELECT OPTION/////////////////
if ($post_status=='published') {
    echo "<option value='draft'>Draft</option>";
}else {
    echo "<option value='published'>Published</option>";
}
?>

</select>
</div>
<div class="form-group"> 
    <label for="post_image">Post Image</label><br>
    <img src="images/<?php echo $post_image;?>" alt="image from database" width="70" height= "50">
    <input type="file" class="form-control" name="post_image">
</div>
<div class="form-group">
    <label for="post_tags">Post tags</label>
    <input value= "<?php echo $post_tags;?>" type="text" class="form-control" name="post_tags">
</div>
<div class="form-group">
    <label for="post_content">Post contect</label>
 <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content;?></textarea>
</div>
<div class="form-group">
    <input class="btn btn-primary" type="submit" class="form-control" name="update_post" value="Update Post">
</div>
</form>
</div>
</div>