    <?php //include "functions.php";?>
        <?php 
        if(isset($_POST['create_user'])){
            $username      = escape($_POST['username']);
            $user_password = escape($_POST['user_password']);
            $user_firstname= escape($_POST['user_firstname']);
            $user_lastname = escape($_POST['user_lastname']);
            $user_email    = escape($_POST['user_email']);
            $user_role     = escape($_POST['user_role']);

        ///////////dealing with the image function////////
            $user_image= $_FILES['user_image']['name'];
            $user_image_temp= $_FILES['user_image']['tmp_name'];
            move_uploaded_file($user_image_temp,"images/$user_image");

        ///////get the randsalt from the db to update//////////
        $query= "SELECT randsalt FROM users";
        $get_randsalt_query=mysqli_query($connection,$query);

        if(!$get_randsalt_query){
            die("QUERY FAILED".mysqli_error($connection));
        }
        /// we can not use the while loop if we want one thing ////
            $row = mysqli_fetch_array($get_randsalt_query);
            $randsalt = $row['randsalt'];
            $hashed_password = crypt($user_password, $randsalt);

        /////////INSERT QUERY////////////////////////
        $query= "INSERT INTO users (username,user_firstname,user_lastname,user_password,user_email,user_role,user_image)";

        $query.=" VALUES ('{$username}','{$user_firstname}','{$user_lastname}','{$hashed_password}','{$user_email}','{$user_role}','{$user_image}')";

        $query_create_user= mysqli_query($connection,$query);
        if ($query_create_user) {
        echo "user added";
        }else{
        die("query failed". mysqli_error($connection)); 
        }
        }
        ?>
        <div class="row">
        <div class="col-lg-12">
        <form  class= "form" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Firstname</label>
            <input type="text" class="form-control" name="user_firstname">
        </div>
        <div class="form-group">
            <label for="title">Lastname</label>
            <input type="text" class="form-control" name="user_lastname">
        </div>
        <div class="form-group">
            <label for="title">Username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="title">Password</label>
            <input type="password" class="form-control" name="user_password">
        </div>
        <div class="form-group">
            <label for="title">Email</label>
            <input type="email" class="form-control" name="user_email">
        </div>
        <div class="form-group">
        <label for="post_category">Role</label>   
        <select class="form-control" name="user_role">
        <option value='subscriber'>Select Options</option>
        <option value='admin'>Admin</option>
        <option value='subscriber' selected>subscriber</option>
        </select>
        </div>
        <div class="form-group">
            <label for="post_image">Image</label>
            <input type="file" class="form-control" name="user_image">
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" class="form-control" name="create_user" value="Create user">
        </div>
        </form>
        </div>
        </div>