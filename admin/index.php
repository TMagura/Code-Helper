<!-- header -->
<?php include "includes/Adheader.php";?>
<?php //include "functions.php";?>
    <div id="wrapper">
 
<!-- navigation -->
<?php include "includes/Adnavigation.php";?>
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col">
                        <h1 class="page-header text-primary">
                            WELCOME TO ADMIN PANEL
                      <small class="text-warning"><?php echo strtoupper($_SESSION['username']);?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

<!-- widgets for dashboard -->        
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php 
                        ///////query to show amount of post////////
                        $query= "SELECT * FROM posts";
                        $select_all_post= mysqli_query($connection,$query);
                        $post_count= mysqli_num_rows($select_all_post);

                        echo "<div class='huge'>{$post_count}</div>";
                        ?>
                    <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Posts</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php 
                        ///////query to show amount of comments////////
                        $query= "SELECT * FROM comments";
                        $select_all_comments= mysqli_query($connection,$query);
                        $comment_count= mysqli_num_rows($select_all_comments);

                        echo "<div class='huge'>{$comment_count}</div>";
                        ?>                       
                                    
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Comments</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <?php 
                    ///////query to show amount of post////////
                    $query= "SELECT * FROM users";
                    $select_all_users= mysqli_query($connection,$query);
                    $users_count= mysqli_num_rows($select_all_users);

                    echo "<div class='huge'>{$users_count}</div>";
                    ?>                   

                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Users</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <?php 
                        ///////query to show amount of post////////
                        $query= "SELECT * FROM categories";
                        $select_all_categories= mysqli_query($connection,$query);
                        $category_count= mysqli_num_rows($select_all_categories);

                        echo "<div class='huge'>{$category_count}</div>";
                        ?>                  

                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Categories</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/Adfooter.php";?>
