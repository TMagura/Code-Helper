    <?php  include "includes/db.php"; ?>
    <?php  include "includes/header.php"; ?>
    <?php
            
        if(!isset($_GET['email']) && !isset($_GET['token'])){
            redirect('index');
            }else{

                $stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token = ?');

                mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $username, $user_email, $token);             
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) < 1) {
                    redirect('index');
                }
                mysqli_stmt_close($stmt);
            
                            
            if(isset($_POST['resetPassword'])){
                if(!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {          

                if($_POST['password'] === $_POST['confirmPassword']){

                    $password = $_POST['password'];
                    $token = $_POST['token'];
                    $email= $_GET['email'];

                    $hashedPassword = password_hash($password,PASSWORD_BCRYPT, array('cost'=>12));

                    $stmt2 = mysqli_prepare($connection, "UPDATE users SET token='{$token}', user_password='{$hashedPassword}' WHERE user_email = ?");

                    mysqli_stmt_bind_param($stmt2, "s", $_GET['email']);
                    mysqli_stmt_execute($stmt2);

                    if(mysqli_stmt_affected_rows($stmt2) == 1){
                       redirect('login.php');
                    }

                    mysqli_stmt_close($stmt2);

                    
                }else{
                    $message ='
                    <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Please use matching passwords!!.
                    </div>';
  
                }
            }else{
                $message ='
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Warning!</strong> Field cannot be empty!!.
                </div>';
            }
       }else{$message="";}
    }
        ?>

        <!-- Navigation -->

        <?php  include "includes/navigation.php"; ?>

        <div class="container">

            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">


                                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                                    <h2 class="text-center">Reset Password</h2>
                                    <p>You can reset your password here.</p>
                                    <div class="panel-body">


                                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                                    <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                                    <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                                </div>
                                            </div>
                                            <?php echo $message;?>
                                            <div class="form-group">
                                                <input type="submit"
                                                 class="btn btn-lg btn-primary btn-block" name="resetPassword" value="Reset Password" >
                                            </div>

                                            <input type="hidden" class="hide" name="token" id="token" value="">
                                        </form>

                                    </div><!-- Body-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <hr>

        <?php include "includes/footer.php";?>

        </div> <!-- /.container -->



