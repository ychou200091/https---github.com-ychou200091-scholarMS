<?php


function check_login_errors(){
   
    if(isset($_SESSION["errors_login"])){
        $errors =  $_SESSION["errors_login"];

        echo "<br>";

        foreach($errors as $error => $message){
            echo '<p class="form-error">Error: ' . $message .'</p>';
        }
        
        
        unset($_SESSION["errors_login"]);

    }else if (isset($_GET["login"]) && $_GET["login"]=== 'success' ){
        echo "<br>";
        echo '<p class = "form-success">Login Success!</p>';

    }
}

function show_login_user(){
    
    
    if(isset($_SESSION["user_id"])){
        echo '<p>Welcome, '.$_SESSION["username"].'</p>';
    }else{
        echo 'You have not login';
    }


}