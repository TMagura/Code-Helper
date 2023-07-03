<?php //include "functions.php";?>
<?php ob_start();?>
<div class="container-fluid">
<div class="row">

<h1 class="page-header">
    USERS TABLE
</h1>
<div class="col-lg-6">
<table class="table table-hover" style="background-color: white;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>User Role</th>
            <th>Image</th>
            <th colspan="2">Roles</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
<?php 
$query = "SELECT * FROM users " ;
$select_all_users_query= mysqli_query($connection,$query);
while ($row = mysqli_fetch_assoc($select_all_users_query)) { 
$user_id= $row['user_id'];
$username= $row['username'];
$user_password= $row['user_password'];
$user_firstname= $row['user_firstname'];
$user_lastname= $row['user_lastname'];
$user_email= $row['user_email'];
$user_image= $row['user_image'];
$user_role= $row['user_role'];

 echo "<tr>";
 echo "<td>{$user_id}</td>";
 echo "<td>{$username}</td>";
 echo "<td>{$user_firstname}</td>";
 echo "<td>{$user_lastname}</td>";
 echo "<td>{$user_email}</td>";
 echo "<td>{$user_role}</td>";
 echo "<td><img width='70' height='50'src ='images/{$user_image}' alt ='image'></td>";

 echo "<td><a href= 'users.php?changeToAdmin={$user_id}'>Admin</a></td>";
 echo "<td><a href= 'users.php?changeToSubscriber={$user_id}'>Subscriber</a></td>";
 
 echo "<td><a href= 'users.php?source=edit_users&u_id={$user_id}'>EDIT</a></td>";
 echo "<td><a href= 'users.php?delete={$user_id}'>DELETE</a></td>";
echo "</tr>";
}
?>


    </tbody>
</table>
</div>
<!-- SUBSCRIBER ROLE IS TO UPDATE USING THE id KEY ON THE GET METHOD -->
<?php
if (isset($_GET['changeToSubscriber'])) {
  $role_id = $_GET['changeToSubscriber'];
  $query="UPDATE users SET user_role='subscriber' WHERE user_id ={$role_id}";
  $role_query = mysqli_query($connection,$query);
  confirm_query($role_query);
  header("Location:users.php");
}
?>
<!-- ADMIN ROLE IS TO UPDATE USING THE id KEY ON THE GET METHOD -->
<?php
if (isset($_GET['changeToAdmin'])) {
  $role_id = $_GET['changeToAdmin'];
  $query="UPDATE users SET user_role='admin' WHERE user_id ={$role_id}";
  $role_query = mysqli_query($connection,$query);
  confirm_query($role_query);
  header("Location:users.php");
}
?>

<?php 
/////DELETE FUNCTION url protected///////
if (isset($_GET['delete'])) {
  if ($_SESSION['user_role']) {
     if($_SESSION['user_role']==='admin'){
      $delete_user_id= mysqli_real_escape_string($connection,$_GET['delete']);
      $query="DELETE FROM users WHERE user_id ={$delete_user_id}";
      $delete_user_query = mysqli_query($connection,$query);
      confirm_query($delete_user_query);
      header("Location:users.php");
  }
 }
}
?> 

</div>
</div>


