<?php
error_reporting(E_ALL ^(E_NOTICE | E_WARNING));
require_once '../classes/lib/config/Configuration.class.php';
$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');

    session_start(); // Starting Session
$flag=0;
    if ($_SESSION['digit'] == $_POST["captcha"] ) {
        $flag=1;
    }
    else if(isset($_POST['submit'])) {
        $error="wrong text entered";
        $_SESSION=NULL;
    }
        
    if($flag==1){
        if (isset($_POST['submit'])) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                   $error = "Username or Password is invalid";
            }
            else
            {
                $username=$_POST['username'];
                if (auth()){
                         $_SESSION['login_user']=$username; // Initializing Session
             //            header("location: success.php"); // Redirecting To Other Page
                         die("<script language='JavaScript'>window.location.replace('http://localhost/efiling/e-Filing/?theme=neptune');</script>");
                    //     exit();
                    }
            }
        }
   }
   
        function validateCaptcha() {
                if (!empty($_POST['captcha']) && $_SESSION["digit"] == $_POST["captcha"]) {  
                       return true;
                } else {
                    return false;
                }
        }

        function validateAuth() {
                if (isset($_POST['submit']) && $_SESSION['login_user']!= NULL) {  
                       return true;
                } else {
                    return false;
                }
        }

        function auth(){
                // Define $username and $password
                $username=$_POST['username'];
                $password=$_POST['password'];
                // Establishing Connection with Server by passing server_name, user_id and password as a parameter
                $connection = mysql_connect("localhost", "root","");
                // To protect MySQL injection for Security purpose
                $username = stripslashes($username);
                $password = stripslashes($password);
                $username = mysql_real_escape_string($username);
                $password = mysql_real_escape_string($password);
                // Selecting Database
                $db = mysql_select_db("ereceiving", $connection);
                // SQL query to fetch information of registerd users and finds user match.
                $query = mysql_query("select * from user where password='$password' AND username='$username'", $connection);
                $rows = mysql_num_rows($query);
                    if ($rows == 1) {
                          return true;
                    }
                    else{
                          return false;
                    }
                mysql_close($connection); // Closing Connection
            }
?>