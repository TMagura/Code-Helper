<?php 
///////// ESCAPE STRINGS FOR SECURITY ////////////
function escape($string){
    global $connection;
return mysqli_real_escape_string($connection,trim($string));
}
?>

<?php 
/// FUNCTION TO REDIRECT TO ANOTHER LOCATION///
function redirect($location){
header("Location:".$location);
exit;////end of function
}
?>

<?php 
/// CHECK IF USER HAS liked/Unlikd a POST
function DoesUserLikedThisPost($post_id='',$user_id=''){
  global $connection;
     $query = "SELECT * FROM likes WHERE post_id= $post_id AND user_id= $user_id ";
     $query_result = mysqli_query($connection,$query);
     return mysqli_num_rows($query_result) >=1 ? true : false;
}
?>

<?php 
/// CHECK HOW MANY likes on a POST
function numberOfLikes($post_id=''){
  global $connection;
     $query = "SELECT likes FROM posts WHERE post_id= $post_id";
     $query_result = mysqli_query($connection,$query);
     if(mysqli_num_rows($query_result)>=1){
      $row = mysqli_fetch_array($query_result);
      return $likeNo = $row['likes'];
     }else{
       return "NOTHING MAN";
     }
}
?>

<?php 
//check if the method used is a valid method POST/GET.
function ifItIsMethod($method=null){
  if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
   return true;
  }else{
    return false;
  }
}
?>
<?php 

function isloggedIn(){
  if (isset($_SESSION['user_role'])) {
    return true;
  }else{
    return false;
  }
}
?>
<?php 
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
 if(isloggedIn()){
  redirect($redirectLocation);
 } 
}
?>


<?php 
////// LOG IN THE USER   ////////
function login_user($username,$password){
  global $connection;
$query="SELECT * FROM users WHERE username='{$username}'";
$select_users_query=mysqli_query($connection,$query);
if (!$select_users_query) {
   die('QUERY FAILED'.mysqli_error($connection));
}
while($row=mysqli_fetch_assoc($select_users_query)){
$db_user_id = $row['user_id'];
$db_username = $row['username'];
$db_passsword = $row['user_password'];
$db_user_firstname = $row['user_firstname'];
$db_user_lastname = $row['user_lastname'];
$db_user_role = $row['user_role'];
}
$password = crypt($password, $db_passsword);
if ($username !==$db_username && $password !== $db_passsword) {
  header("Location:login.php");
}
elseif ($username ==$db_username && $password ==$db_passsword) {

$_SESSION['username']=$db_username;
$_SESSION['firstname']=$db_user_firstname;
$_SESSION['lastname']=$db_user_lastname;
$_SESSION['user_role']=$db_user_role;
$_SESSION['user_id']=$db_user_id;

    header("Location:index.php");
}
}
?> 

<?php
////////// INSERT FUNCTION///////////// 
function insert_categories()
{global $connection;
    if(isset($_POST['submit']) && !empty($_POST['cat_title'])){ 
        $cat_title = mysqli_real_escape_string($connection,$_POST['cat_title']);


        $query="INSERT INTO categories (cat_title) VALUES (?) ";
        $stmt=mysqli_prepare($connection,$query);
        mysqli_stmt_bind_param($stmt,'s',$cat_title);
        mysqli_stmt_execute($stmt);
        
        if(!$stmt){
            die('DIED QUERY'.mysqli_error($connection));
        }
        }elseif(isset($_POST['submit']) && empty($_POST['cat_title'])) {
            echo "fill in the textbox";
        }
}
?>


<?php
 //////////// SELECT ALL FUNCTION///////// 
function select_all_categories()
{global $connection;
    $query = "SELECT * FROM categories" ;
    $select_all_categories_query= mysqli_query($connection,$query);
           while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
            $cat_title= $row['cat_title']; 
            $cat_id= $row['cat_id'];
            ?>
        <tr>
            <td><?php echo $cat_id;?></td>
            <td><?php echo $cat_title;?></td>
            <td><a href="categories.php?delete=<?php echo $cat_id;?>">DELETE</a></td>
            <td><a href="categories.php?update=<?php echo $cat_id;?>">UPDATE</a></td>
        </tr>
        <?php }
    

        
}?>

<?php
//////////// DELETE FUNCTION //////////////
function delete_categories()
{ global $connection;
        // FINDING THe VALUE WITH THE GET REQUEST and DELETE
        if (isset($_GET['delete'])) {
            $delete_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = '{$delete_cat_id}' ";
            $delete_cat_query= mysqli_query($connection,$query);
      
          // the header fuction makes the page get refreshed at once after delete clicked
        header("Location:categories.php");
          }

        }
        
?>

<?php 
function confirm_query($the_query)
{ global $connection;
    if (!$the_query) {
       die("QUERY FAILED".mysqli_error($connection));
    
    }
}

?>
 <?php 
 ////////prevent picture fall back NO PIC ON POST CREATION///////
function image_placeholder($image=''){
if(!$image){
  return 'ccc.png';
}else {
  return $image;
  }
 } 
 ?>


<?php 
////// CREATING ONLINE USER COUNT FUNCTION///////
function online_users(){
   if (isset($_GET['onlineusers'])) {
    global $connection;
    if (!$connection) {
        echo "no";
        session_start();
        include "../includes/db.php"; 
    
$session =session_id();
$time = time();
$time_out_inseconds = 05;
$time_out = $time - $time_out_inseconds;

///QUERY TO CHECK IF THIS USER IS ALREADY online OR.....///
$query= "SELECT * FROM users_online WHERE session_online ='{$session}' ";
$online_query= mysqli_query($connection,$query);
if(!$online_query){die("failed".mysqli_error($connection));}
$count= mysqli_num_rows($online_query);


if($count==NULL){
//// if its Null it means the user session is not online but now online//
    $query_session="INSERT INTO users_online (session_online,time_online) VALUES ('$session','$time')";
    $query_insert_session=mysqli_query($connection,$query_session);
    if(!$query_insert_session){die("failed".mysqli_error($connection));}
 }
 else {
  mysqli_query($connection,"UPDATE users_online SET time_online='{$time}' WHERE session_online='{$session}'"); 
}
$online_users_query=mysqli_query($connection,"SELECT * FROM users_online WHERE time_online >= {$time_out}");
echo $online_users_count=mysqli_num_rows($online_users_query);
}
 }
}
online_users();
?>
    
    <?php 
    /////creating the views based on the user////////
    function is_admin($username=''){
    global $connection;
    $query= "SELECT user_role FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection,$query);
    confirm_query($result);
    $row= mysqli_fetch_array($result);
    if ($row['user_role']=='admin'){
    return true;
    }else{
        return false;
    }

    }
    ?>

    <?php 
    ////// check to avoid duplicate USERNAME in the registration process//
    function username_exits($username){
    global $connection;
     
    $query = "SELECT username FROM users WHERE username = '{$username}'";
    $user_exist = mysqli_query($connection,$query);
    confirm_query( $user_exist);
    if (mysqli_num_rows($user_exist) > 0) {
        return true;
    }else {
        return false;
    }
    }
    ?>

<?php 
    ////// check to avoid duplicate EMAILS in the registration process//
    function email_exits($email){
    global $connection;
     
    $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
    $email_exist = mysqli_query($connection,$query);
    confirm_query( $email_exist);
    if (mysqli_num_rows($email_exist) > 0) {
        return true;
    }else {
        return false;
    }
    }
    ?>


    <?php 
    ///// LOOPING OUT ERRORS ON THE REGISTRATION PAGE////
    function registration_errors(){
        global $connection;
  $error=['username'=>'','email'=>'','password'=>''];

  //// inserting values now in the assoc array///
  if(strlen($username)<4){
    $error['username'] = 'Username needs to be longer than 4 characters';
  }
  if($username==''){
    $error['username'] = 'Username cannot be empty';
  }
  if(username_exits($username)){
    $error['username'] = 'Username already exists';
  }
  if($email==''){
    $error['email'] = 'Email needs to be longer than 4 characters';
  }
  if(email_exits($email)){
    $error['email'] = 'Email already Exists';
  }
  if($password==''){
    $error['password'] = 'Password cannot be empty';
  }
  if(strlen($password)<4){
    $error['password'] = 'Password needs to be stronger more than 4 characters';
  }
    
  foreach ($variable as $key => $value) {
    if(empty($value)){
    ///then in here put the code will be executed if no errors exists
    }
  }
}
 ?>