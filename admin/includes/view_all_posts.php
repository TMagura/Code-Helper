<?php ob_start();?>
   <div class="container-fluid">
      <div class="row">
            <div class="col-lg-12">
               <h1 class="page-header">POSTS TABLE</h1>
            </div>
    <?php 
            /////////// Dealing with the checkbox arrays///////////
        if (isset($_POST['checkBoxArray'])) {

            foreach ($_POST['checkBoxArray'] as $postIdValue) {
                
                    $bulk_option=$_POST['bulk_option'];
                switch ($bulk_option) {

                case 'published':
                    $query= "UPDATE posts SET post_status= '{$bulk_option}' WHERE post_id = {$postIdValue}"; 
                    $publish_query=mysqli_query($connection,$query);
                    confirm_query($publish_query);  
                break;

                case 'draft':
                    $query= "UPDATE posts SET post_status= '{$bulk_option}' WHERE post_id = {$postIdValue}";
                    $draft_query=mysqli_query($connection,$query);
                    confirm_query($draft_query);    
                break;

                case 'delete':
                    $query="DELETE FROM posts WHERE post_id = {$postIdValue}";
                    $delete_query=mysqli_query($connection,$query); 
                    confirm_query($delete_query); 
                break;

                case 'clone':
                        $query = "SELECT * FROM posts WHERE post_id = {$postIdValue} " ;
                        $select_all_posts_query= mysqli_query($connection,$query);
                 while ($row = mysqli_fetch_assoc($select_all_posts_query)) { 
                        $post_id= $row['post_id'];
                        $post_author= $row['post_author'];
                        $post_user_id= $row['post_user_id'];
                        $post_title= $row['post_title'];
                        $post_category_id= $row['post_category_id'];
                        $post_status= $row['post_status'];
                        $post_image= $row['post_image'];
                        $post_tags= $row['post_tags'];
                        $post_content= $row['post_content'];
                        $post_date= $row['post_date'];                      
                    }

                        $query= "INSERT INTO posts (post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_status,post_user_id)";

                        $query.=" VALUES ('{$post_category_id}','{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}','{$post_user_id}')";

                        $query_clone_posts= mysqli_query($connection,$query);
                        confirm_query($query_clone_posts);
                break;

                default:
                      echo "please select the option";
                break;
                }
             }
        }
   ?>

    <form action="" method= "post">
        <table style="background-color: white;" class="table table-hover table-striped" >
           <div id="bulkOptionContainer" class="col-xs-4">
            <select name="bulk_option" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>  
            </select>
          </div>
     <div class="col-xs-4">
      <input type="submit" class=" btn btn-success" name="submit" value="Apply">
       <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes" ></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date modified</th>
                <th colspan="4">Actions</th>
            </tr>
        </thead>
    <tbody>
        <?php 
            if($_SESSION['username']){$name = $_SESSION['username'];}
                $query = "SELECT * FROM posts WHERE post_author = '{$name}' ORDER BY post_id DESC " ;
                $select_all_posts_query= mysqli_query($connection,$query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) { 
                $post_id= $row['post_id'];
                $post_users_id=$row['post_user_id'];
                $post_author= $row['post_author'];
                $post_title= $row['post_title'];
                $post_category_id= $row['post_category_id'];
                $post_status= $row['post_status'];
                $post_image= $row['post_image'];
                $post_tags= $row['post_tags'];
                $post_comment_count= $row['post_comment_count'];
                $post_date= $row['post_date'];
                $post_views_count= $row['post_views_count'];

            echo "<tr>";
         ?>
     <td><input type="checkbox" name="checkBoxArray[]" class="checkBoxes" value="<?php echo $post_id;?>"></td>
        <?php
            echo "<td>{$post_id}</td>";

            //// GET THE USERNAME FOR THE POST//////
                $query_author = "SELECT * FROM users WHERE user_id = $post_users_id";
                $users_query_author = mysqli_query($connection,$query_author);
                confirm_query($users_query_author);
            while ($row = mysqli_fetch_assoc($users_query_author)) {
                $username = $row['username'];
                echo "<td>{$post_author}</td>";
            }
                echo "<td>{$post_title}</td>";

            //////// Category_ID and Post_ID Relationship/////////////
                $query_select_cat_id = "SELECT * FROM categories WHERE 
                cat_id =  {$post_category_id} " ;
                $category_relate_query = mysqli_query($connection,$query_select_cat_id);

            while ($row = mysqli_fetch_assoc($category_relate_query)) {
                $cat_title = $row['cat_title']; 
                $cat_id= $row['cat_id'];
                echo "<td>{$cat_title}</td>";
            }
                echo "<td>{$post_status}</td>";
                echo "<td><img width='70' height='50'src ='images/{$post_image}' alt ='image'></td>";
                echo "<td>{$post_tags}</td>";

            //// get number of rows in the comments for a specific post_id
                $comments_query="SELECT * FROM comments WHERE comment_post_id = $post_id";
                $comment_count_query=mysqli_query($connection,$comments_query);
            //   $row= mysqli_fetch_array($comment_count_query);
            //   $comment_id = $row['comment_id'];
                $comments_num= mysqli_num_rows($comment_count_query);

                echo "<td><a href= 'post_comments.php?c_id={$post_id}'>{$comments_num}</a></td>";
                echo "<td><a href= '../post.php?p_id={$post_id}'>{$post_views_count}</a></td>";
                echo "<td>{$post_date}</td>";
                echo "<td><a class='btn btn-success' href= '../post.php?p_id={$post_id}'>VIEW</a></td>";
                echo "<td><a class='btn btn-info' href= 'posts.php?source=edit_post&p_id={$post_id}'>EDIT</a></td>";
                echo "<td><a class='btn btn-warning' href= 'posts.php?reset={$post_id}'>Reset Views</a></td>";
            ///// use inline javascript////
            //echo "<td><a onClick=\"javascript:return confirm('comfirm delete');\" href= 'posts.php?delete={$post_id}'>DELETE</a></td>";

            ?>
            <!-- use form instead to secure the data -->
            <form method="post">
               <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
               <td><input class="btn btn-danger" type="submit" name="delete" value="DELETE"></td>
            </form>

        <?php
              echo "</tr>";
            }
        ?>
                    </tbody>
                </table>
            </form>
            <?php 

            /// DELETE A POST ////////
            if (isset($_POST['delete'])) {
                $delete_post_id= $_POST['post_id'];
                $query="DELETE FROM posts WHERE post_id ={$delete_post_id}";
                $delete_post_query = mysqli_query($connection,$query);
                confirm_query($delete_post_query);
                header("Location:posts.php");
            }

            ?>
            <?php 
            ////////// RESET VIEWs COUNT//////
            if (isset($_GET['reset'])) {
                $reset_post_id= $_GET['reset'];
                $query="UPDATE posts SET post_views_count = 0 WHERE post_id ={$reset_post_id}";
                $reset_post_query = mysqli_query($connection,$query);
                confirm_query($reset_post_query);
                header("Location:posts.php");
            }
            ?>
         </div>
      </div>
   </div>

