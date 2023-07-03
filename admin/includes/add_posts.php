    <?php //include "functions.php";

    ?>
    <?php 
     if(isset($_POST['create_post'])){

    //// GET THE USERNAME FOR THE POST//////
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
        $query_author = "SELECT * FROM users WHERE username = '{$username}'";
        $users_query_author = mysqli_query($connection,$query_author);
        confirm_query($users_query_author);
        while($row = mysqli_fetch_assoc($users_query_author)){
        $post_users_id = $row['user_id'];
        $username= $row['username'];}

    //$post_user_id= $_POST['post_user_id'];
        $post_title      = $_POST['post_title'];
        $post_content    = $_POST['post_content'];
        $post_category_id= $_POST['post_category'];
        $post_status     = $_POST['post_status'];
        $post_tags       = $_POST['post_tags'];

////////dealing with the date function////////////
        $post_date= date('d-m-y');

///////////dealing with the image function////////
        $post_image= $_FILES['post_image']['name'];
        $post_image_temp= $_FILES['post_image']['tmp_name'];
        move_uploaded_file($post_image_temp,"images/$post_image");

/////////INSERT QUERY///////////
        $query= "INSERT INTO posts (post_author,post_category_id,post_title,post_user_id,post_date,post_image,post_content,post_tags,post_status)";

        $query.=" VALUES ('{$username}','{$post_category_id}','{$post_title}','{$post_users_id}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

        $query_create_posts= mysqli_query($connection,$query);
        if ($query_create_posts) {
            echo "
            <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Post successfully Added  :click to <a href='posts.php'>view all posts</a></strong>
            </div><br>
            ";

    ////this function provide the recently added id in the database//
    //echo mysqli_insert_id($connection);
        }else{
            echo "
            <div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Post Rejected :Internal Error </strong>
            </div><br>
            ";
        }
      }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <form  class= "form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Post title</label>
                <input type="text" class="form-control" name="post_title" required>
            </div>
            <div class="form-group">
               <label for="post_category">Category</label>   
               <select class="form-control" name="post_category">

        <?php 
        ///////// GET CATEGORY VALUES FOR SELECT OPTION/////////////////

            $query = "SELECT * FROM categories";
            $categories_query = mysqli_query($connection,$query);
            confirm_query($categories_query);
            while ($row = mysqli_fetch_assoc($categories_query)) {
            $cat_title = $row['cat_title']; 
            $cat_id= $row['cat_id'];

          echo "<option value='{$cat_id}' selected >{$cat_title}</option>";
        }
    ?>
               </select>
           </div>


            <div class="form-group">
                <label for="post_user_id">Post Author</label>
                <select class="form-control" name="" >
            <?php 
                //// GET THE USERNAME FOR THE POST//////
                if (isset($_SESSION['username'])) {
                    $username=$_SESSION['username'];
                }
            $query_author = "SELECT * FROM users WHERE username= '{$username}'";
            $users_query_author = mysqli_query($connection,$query_author);
            confirm_query($users_query_author);
            while($row = mysqli_fetch_assoc($users_query_author)){
            $post_users_id = $row['user_id'];
            $username= $row['username'];}
            echo "<option value='{$post_users_id}' selected disabled>{$username}</option>";

        ?>
            </select>
            </div> 

                <div class="form-group">
                    <label for="post_date">Post Date</label>
                    <input type="date" name="post_date">
                </div>

                <div class="form-group">
                    <label for="post_status">Post status</label>
                <select name="post_status" id="">
                <option value="draft">Select Option</option>
                    <option value="draft">Draft</option>
                    <option value="published">Publish</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="post_image">Post Image</label>
                    <input type="file" class="form-control" name="post_image" required>
                </div>
                <div class="form-group">
                    <label for="post_tags">Post tags</label>
                    <input type="text" class="form-control" name="post_tags"required>
                </div>
                <div class="form-group">
                    <label for="post_content">Post contect</label>
                <textarea class="form-control" name="post_content" id="" cols="10" rows="2"required></textarea>
                </div>
                <div class="form-group">
                <input class="btn btn-primary" type="submit" class="form-control" name="create_post" value="Publish Post">
            </div>
            </form>
        </div>
     </div>