    <?php  include "includes/db.php"; ?>
    <?php  include "includes/header.php"; ?>

        <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
        <?php 
            if (isset($_GET['Lang']) && !empty($_GET['Lang'])) {
                $_SESSION['Lang'] = $_GET['Lang'];

                if(isset($_SESSION['Lang']) && $_SESSION['Lang']!=$_GET['Lang']){
                    echo "<script type='text/javascript'>location.reload;</script>";//it reloads the page 
                }
            }
            if(isset($_SESSION['Lang'])){
                include "includes/languages/".$_SESSION['Lang'].".php";
            }else {
                include "includes/languages/en.php";
            }

            if (isset($_POST['submit'])) {
                 if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){

                $username = mysqli_real_escape_string($connection,$_POST['username']);
                $email    = mysqli_real_escape_string($connection,$_POST['email']);
                $password = mysqli_real_escape_string($connection,$_POST['password']);
                $username =trim($username);
                $email    =trim($email);
                $password =trim($password);

             if(!username_exits($username) && !email_exits($email)){

                $query= "SELECT randsalt FROM users";
                $get_randsalt_query=mysqli_query($connection,$query);

                if(!$get_randsalt_query){
                    die("QUERY FAILED".mysqli_error($connection));
                }
                /// we can not use the while loop if we want one thing ////
                    $row = mysqli_fetch_array($get_randsalt_query);
                    $randsalt = $row['randsalt'];

                    $password = crypt($password, $randsalt);

                $query = "INSERT INTO users (username,user_email,user_password,user_role) VALUES ('{$username}','{$email}','{$password}','subscriber')";
                $register_user_query= mysqli_query($connection,$query);
                confirm_query($register_user_query);

                $message ='
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success :)</strong> Successfully Registered.<br><br>
                <a class="btn btn-success btn-block " href="index.php">CLICK TO LOG IN </a>
                </div>
                ';
                    
                }elseif(username_exits($username) && !email_exits($email)){
                    $message ='
                    <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> This Username already Exists!!.
                    </div>';
            }elseif(!username_exits($username) && email_exits($email)){
                $message ='
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Warning!</strong> This Email already Exists!!.
                </div>';
        }else {            
            $message ='
            <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Warning!</strong> Username and Email already Exists!!.
            </div>';
            }
        }else{
            $message ='
            <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Warning!!  :</strong> Fill in all the fields.
            </div>';
        }
    }
    else {
        $message="";
    } 
    ?>

        <!-- Page Content -->
        <div class="container">
        <form class="navbar-form navbar-right" id="language_form" action="" method= "get">
            <div class="form-group">
                <select class="form-control"  onchange= "changeLanguage()"name="Lang" >
                    <option value="en" <?php if(isset($_SESSION['Lang']) && $_SESSION['Lang']=='en'){echo "selected";}?> >English</option>
                    <option value="es" <?php if(isset($_SESSION['Lang']) && $_SESSION['Lang']=='es'){echo "selected";}?> >Spanish</option>
                </select>       
            </div>
        </form>
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1><?php echo _REGISTER;?></h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME;?>"
                                    autocomplete="on"
                                    value="<?php echo isset($username) ? $username :''?>">
                                    
                                    <!--to show previously entered data we put the value to be the inserted previous data--> 
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL;?>"
                                    autocomplete="on"
                                    value="<?php echo isset($email) ? $email :''?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD;?>">
                                </div>
                            
                                <?php echo $message;?>

                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _REGISTER;?>">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

                <hr>
        <script>

        function changeLanguage(){
            document.getElementById('language_form').submit();
        }

        </script>
        <?php include "includes/footer.php";?>
