<?php //include "functions.php";?>
<?php ob_start();?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-3">
<h1 class="page-header">
    COMMENTS TABLE
</h1>
<table class="table table-hover">
    <thead>
        <tr>
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
$query = "SELECT * FROM comments " ;
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
 echo "<td><a href= 'comments.php?approve={$comment_id}'>Approve</a></td>";
 echo "<td><a href= 'comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
 echo "<td><a href= 'comments.php?delete={$comment_id}'>DELETE</a></td>";
echo "</tr>";
}
?>


    </tbody>
</table>
<!-- UNAPPROVE IS TO UPDATE USING THE id KEY ON THE GET METHOD -->
<?php
if (isset($_GET['unapprove'])) {
  $unapprove_comment_id = $_GET['unapprove'];
  $query="UPDATE comments SET comment_status='unapproved' WHERE comment_id ={$unapprove_comment_id}";
  $unapprove_comment_query = mysqli_query($connection,$query);
  confirm_query($unapprove_comment_query);
  header("Location:comments.php");
}
?>
<!-- APPROVE IS TO UPDATE USING THE id KEY ON THE GET METHOD -->
<?php
if (isset($_GET['approve'])) {
  $approve_comment_id = $_GET['approve'];
  $query="UPDATE comments SET comment_status='approved' WHERE comment_id ={$approve_comment_id}";
  $approve_comment_query = mysqli_query($connection,$query);
  confirm_query($approve_comment_query);
  header("Location:comments.php");
}
?>

 <!-- DELETE USING THE id KEY ON THE GET METHOD -->
<?php
if (isset($_GET['delete'])) {
  $delete_comment_id = $_GET['delete'];
  $query="DELETE FROM comments WHERE comment_id ={$delete_comment_id}";
  $delete_comment_query = mysqli_query($connection,$query);
  confirm_query($delete_comment_query);
  header("Location:comments.php");
}
?>

</div>
</div>
</div>

