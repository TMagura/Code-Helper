    <?php  include "includes/db.php"; ?>
    <?php  include "includes/header.php"; ?>
            <!-- Navigation -->

     <?php  include "includes/navigation.php"; ?>
       <?php 
        if (ifItIsMethod('post')) {
                if(isset($_POST['email']) && !empty($_POST['email'])){
                    $email= $_POST['email'];
                    $length=50;
                    $token= bin2hex(openssl_random_pseudo_bytes($length));
                    ///use this function to check email in db.//
             
                if(email_exits($email)){
                    $query= "UPDATE users SET token = '{$token}' WHERE user_email = ? ";
                    $stmt= mysqli_prepare($connection, $query);

                    if($stmt){
                        mysqli_stmt_bind_param($stmt , "s" , $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);

                        redirect("reset.php?email=$email&token=$token");

                    }else{
                        echo mysqli_error($connection);
                    }
                }else {
                    $message ='
                    <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Email does not exist!!.
                    </div>';
                }
            }else{
                $message ='
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Warning!</strong> Field cannot be empty!!.
                </div>';
            }
        }else{
            $message="";
        }
   ?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email" value ="<?php echo isset($_POST['email']) ? $_POST['email'] :'';?>">
                                            </div>
                                        </div>
                                        <?php echo $message;?>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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

