<?php
include('./auth/login.php'); // Includes Login Script
$error='';
    if(isset($_SESSION['login_user']))
        {
        die("<script language='JavaScript'>window.location.replace('http://localhost/efiling/e-Filing/');</script>");
    }
?>
<!DOCTYPE html>
<html>
    <head>
            <title>Login Form</title>
            <link href="css/style.css" rel="stylesheet" type="text/css">
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script src="script_js/script.js"></script>
    </head>

    <body style="background-color:#4d0000">
        <div id="main" style="background-color: #e0e0d1;">
            <div id="login" style="background-color:white;">
                <h2 style="background-color:#990000; color: white">Login Form</h2>
                <form action="" method="post" name="submit">
                        <br>
                        <label>Username :</label>
                            <input id="username" name="username" placeholder="username" type="text" required/>
                        <br>
                        <br>
                        <label>Password :</label>
                            <input id="password" name="password" placeholder="password" type="password" required />
                        <br>
                        <span>
                            <?php
                               // echo auth();
                                    if(!validateAuth()&&!empty($_POST['username'])&&!empty($_POST['password'])&& !auth())
                                echo "Wrong Credential"; 
                            ?>
                        </span>
                        <p>
                            <img id="reload" src="resource/reload.png" align="right" style="margin-left: 220px; "/>
                        <div id="imgdiv" align="center"><img id="img" src="captcha/captcha.php" width="120" height="30" border="1" alt="CAPTCHA"/>
                        
                        </div>
                       
                        <p>
                            <input id="captchatext" type="text" size="6" maxlength="5" name="captcha" required /> 
                            
                            <small>Copy the digits from the image into this box</small></p>
                            <input id="button" name="submit" type="submit" value=" Login ">
                        <span>
                            <?php
                                if(!validateCaptcha()&&!empty($_POST['captcha']))
                                        echo "Captcha wrong"; 
                            ?>
                        </span>
                    </form>
            </div>
        </div>
    </body>
</html>


