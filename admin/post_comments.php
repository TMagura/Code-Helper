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

<?php //include "functions.php";?>

<?php ob_start();?>

<?php 
    if (isset($_GET['c_id'])) {
    $the_post_id = mysqli_real_escape_string($connection,$_GET['c_id']);
////////GET THE TITLE/////
$queryT = "SELECT * FROM posts WHERE post_id = $the_post_id" ;
$select_title_query= mysqli_query($connection,$queryT);
$row = mysqli_fetch_assoc($select_title_query);
$post_comment_title = $row['post_title'];

?>
<div class="container-fluid">
<div class="row">
<div class="col">
<h1 class="page-header text-bold" >
    COMMENTS FOR TITLE : <span><?php echo $post_comment_title;?></span>
</h1>

<form action="" method= "post">
<table style="background-color: white;" class="table table-hover table-striped" >

<div id="bulkOptionContainer" class="col-xs-4">
<select name="bulk_option" id="" class="form-control">
    <option value="">Select Options</option>
    <option value="content">Content</option>
    <option value="draft">Draft</option>
    <option value="clone">Clone</option>
    <option value="delete">Delete</option>  
</select>
</div>
<div class="col-xs-4">
<input type="submit" class=" btn btn-success" name="submit" value="Apply">
<!-- <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a> -->
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes" ></th>
            <th>ID</th>
            <th>Author</th>
            <th>Content</th>
            <th>Responded Post Title</th>
            <th>Email</th>
            <th>Status</th>
            <th>Date</th>
            <th colspan="4">Action</th>
        </tr>
    </thead>
    <tbody>
<?php 
$query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id" ;
$select_all_comments_query= mysqli_query($connection,$query);
while ($row = mysqli_fetch_assoc($select_all_comments_query)) { 
$comment_id= $row['comment_id'];
$comment_author= $row['comment_author'];
$comment_email= $row['comment_email'];
$comment_content= $row['comment_content'];
$comment_post_id= $row['comment_post_id'];
$comment_status= $row['comment_status'];
$comment_date= $row['comment_date'];
$sub_comment_content=substr($comment_content,0,20);


 echo "<tr>";
  ?>
<td><input type="checkbox" name="checkBoxArray[]" class="checkBoxes" value="<?php echo $comment_id;?>"></td>
 <?php
 echo "<td>{$comment_id}</td>";
 echo "<td>{$comment_author}</td>";
 echo "<td>{$sub_comment_content}</td>";

//////// Comment_ID and Post_ID Relationship/////////////
$query_select_post_id = "SELECT * FROM posts WHERE 
post_id =  {$comment_post_id}";
$comment_relate_query = mysqli_query($connection,$query_select_post_id);
while ($row = mysqli_fetch_assoc($comment_relate_query)){
$post_title = $row['post_title'];
$post_id = $row['post_id']; 
echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
}

 echo "<td>{$comment_email}</td>";
 echo "<td>{$comment_status}</td>";
 echo "<td>{$comment_date}</td>";
 ?>
 <td><input class="btn btn-danger" type="submit" name="delete" value="delete"></td>
 <?php
 echo "<td><a href='post_comments.php?delete={$comment_id}&c_id=".$_GET['c_id']."'>DELETE</a></td>";
 echo "</tr>"; 
}
?>

    </tbody>
</table>
</form>

<?php 
/////////// Dealing with the checkbox arrays///////////
if (isset($_POST['checkBoxArray'])) {

foreach ($_POST['checkBoxArray'] as $postIdValue) {
    $bulk_option=$_POST['bulk_option'];
    switch ($bulk_option) {

        case 'delete':
        $query="DELETE FROM comments WHERE comment_id = {$postIdValue}";
        $delete_query=mysqli_query($connection,$query); 
        confirm_query($delete_query); 
        break;
///////for testing 
        case 'content':
            $query= "UPDATE comments SET comment_content = 'wakaipa' WHERE comment_id = {$postIdValue}"; 
            $content_query=mysqli_query($connection,$query);
            confirm_query($content_query);  
        break;

        default:
           echo "please select the option";
            break;
    }
}
header("Location:post_comments.php?c_id=".$_GET['c_id']."");
}
?>

 <!-- DELETE USING THE id KEY ON THE GET METHOD -->
<?php

if (isset($_GET['delete'])) {
  $delete_comment_id = $_GET['delete'];
  $query="DELETE FROM comments WHERE comment_id ={$delete_comment_id}";
  $delete_comment_query = mysqli_query($connection,$query);
  confirm_query($delete_comment_query);
  header("Location:post_comments.php?c_id={$the_post_id}");
}
?>

<!-- trying with a button -->
<?php 
if (isset($_POST['delete'])) {
  $query="DELETE FROM comments WHERE comment_id ={$comment_id}";
  $delete_comment_query = mysqli_query($connection,$query);
  confirm_query($delete_comment_query);
  header("Location:post_comments.php?c_id={$the_post_id}");
}

?>

<?php
//////// AFTER THE GET IF ////////
 }else {
   header("Location:../posts.php"); 
}
?>
</div>
</div>
</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>