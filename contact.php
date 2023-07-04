    <?php  include "includes/db.php"; ?>
    <?php  include "includes/header.php"; ?>
                <!-- Navigation -->
                
    <?php  include "includes/navigation.php"; ?>
                
    <?php 
        if (isset($_POST['submit'])) {

            $to_admin ="admin@gmail.com";
            $to       = escape($to_admin);
            $subject  = escape($_POST['subject']);
            $body     = escape(wordwrap($_POST['body']));
            $header   = "From:".($_POST['email']);

         if(!empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['body'])){

                //// HERE USE THE MAAIL FUNCTION/////
                mail($to,$subject,$body,$header);
                        
                $message ='
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success :)</strong> Message is sent Successfully.
                </div>';
             }elseif(empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['body'])) {
                
                $message ='
                <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Warning!</strong> Fields cannot be empty!!.
                </div>';
                }
            }else{
            
                $message="";
            }
            ?>

    <!-- Page Content -->
            <div class="container">
            
            <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Contact</h1> 
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email: @example.com" value = "<?php echo isset($_POST['email']) ? $_POST['email'] :'';?>">
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="sr-only">subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value = "<?php echo isset($subject) ? $subject :'';?>">
                                </div> 
                                <div class="form-group">
                                    <label for="body" class="sr-only">Body</label>
                                    <textarea name="body" id="body" class="form-control" placeholder="body" cols="30" rows="3"><?php echo isset($body) ? $body :'';?></textarea>
                                </div>                            
                                <?php echo $message;?>                                                
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="SEND MESSAGE">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
     <hr>
    <?php include "includes/footer.php";?>
