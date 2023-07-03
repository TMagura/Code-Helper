
<!-- FORM AND THE UPDATE FUNCTION -->
<form action="" method="post">
        <label for="cat_title"> Edit Category</label>
    <div class="form-group">
        <?php 
          if (isset($_GET['update'])) {
            $update_cat_id = $_GET['update'];
            $query_update = "SELECT * FROM categories WHERE cat_id =  {$update_cat_id} " ;
            $update_categories_query = mysqli_query($connection,$query_update);
        
        while ($row = mysqli_fetch_assoc($update_categories_query)) {
        $cat_title = $row['cat_title']; 
        $cat_id= $row['cat_id'];
        echo "<input value = '{$cat_title}' type='text' class='form-control' name='cat_title'>";
         }
        } ?>

<?php 
// UPDATE FUNCTION

if(isset($_POST['update']) && !empty($_POST['cat_title'])){ 
    $cat_title_update = mysqli_real_escape_string($connection,$_POST['cat_title']);
    $query="UPDATE categories SET cat_title = ? WHERE cat_id =  ? " ;
/// using prepared statements//////
    $stmt=mysqli_prepare($connection,$query);
    mysqli_stmt_bind_param($stmt,"si",$cat_title_update,$cat_id);
    mysqli_stmt_execute($stmt);

    if(!$stmt){
        die('DIED QUERY'.mysqli_error($connection)); 
    }
    header("Location:categories.php");
    }elseif(isset($_POST['update']) && empty($_POST['cat_title'])) {
        echo "fill in the textbox";
    }

?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update category">
    </div>
</form>

