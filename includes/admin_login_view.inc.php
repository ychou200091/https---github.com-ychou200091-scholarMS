<?php


function check_login_errors(){
   
    if(isset($_SESSION["errors_login"])){
        $errors =  $_SESSION["errors_login"];

        echo "<br>";

        foreach($errors as $error => $message){
            echo '<p class="form-error" style="color: red;">Error: ' . $message .'</p>';
        }
        
        
        unset($_SESSION["errors_login"]);

    }else if (isset($_GET["login"]) && $_GET["login"]=== 'success' ){
        echo "<br>";
        echo '<p class = "form-success" style="color: green;">Login Success!</p>';

    }
}
function set_login_section(){
    if(isset($_SESSION["user_id"])){
        echo '<p>[ '.$_SESSION["username"]. ' ]  <a href="includes/logout.inc.php">Logout</a></p>';
        echo '';
    }else{
        echo '<a href="./login.php">Login</a> / <a href="signup.php">Sign Up</a>';
    }
}
function show_login_user(){
    
    if(isset($_SESSION["user_id"])){
        echo '<p>Welcome, '.$_SESSION["username"].'</p>';
    }else{
        ;
    }


}