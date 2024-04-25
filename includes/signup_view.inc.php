<?php
declare(strict_types=1);

function check_signup_errors(){
    #echo "<p>hi" .var_dump($_SESSION). "</p>";
    if(isset($_SESSION["errors_signup"])){
        $errors =  $_SESSION["errors_signup"];

        echo "<br>";

        foreach($errors as $error => $message){
            echo '<p class="form-error">Error: ' . $message .'</p>';
        }
        
        unset($_SESSION["errors_signup"]);

    }else if (isset($_GET["signup"]) && $_GET["signup"]=== 'success' ){
        echo "<br>";
        echo '<p class = "form-success">Sign-up Success!</p>';
        unset($_SESSION["signup_data"]);

    }
}

function signup_inputs(){
    // echo '
    // <input type="text" name="username" placeholder="Username" >
    // <input type="email" name="email" placeholder="Email" >
    // <input type="password" name="password" placeholder="Password" >
    // <input type="Submit" value="Sign Up">';
    #username field
    if(isset($_SESSION["signup_data"]["username"]) &&
        !isset($_SESSION["errors_signup"]["username_taken"])){
        echo '<input type="text" name="username" placeholder="Username" value="'.$_SESSION["signup_data"]["username"].'">';
    }else{
        echo '<input type="text" name="username" placeholder="Username" >';
    }
    #password field
    echo '<input type="password" name="password" placeholder="Password">';
    #email field
    if(isset($_SESSION["signup_data"]["email"]) &&
        !isset($_SESSION["errors_signup"]["email_taken"]) &&
        !isset($_SESSION["errors_signup"]["email_invalid"])
        ){
        echo '<input type="email" name="email" placeholder="Email" value="'.$_SESSION["signup_data"]["email"].'">';
    }else{
        echo '<input type="email" name="email" placeholder="Email" >';
    }
    echo '<input type="Submit" value="Sign Up">';
}
