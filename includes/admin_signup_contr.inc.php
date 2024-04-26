<?php
# handling processing data 
# pass data from view to controller, visa versa


declare(strict_types=1);

function is_input_empty(string $username, string $pwd, string $email): bool{
    if(empty($username)|| empty($pwd) || empty($email) ){
        return true;
    }
    else {return false;}

}

function is_email_invalide(string $email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){  
        return false;
    }else{
        return true;
    }
}

function is_username_taken(object $pdo, string $username){
    
    if (get_username($pdo, $username)){
        return true;
    }
    else{
        return false;
    }
}


function is_email_regiestered(object $pdo, string $email){
    
    if (get_email($pdo, $email)){
        return true;
    }
    else{
        return false;
    }
}

function create_user(object $pdo, string $username, string $pwd, string $email){

    set_user( $pdo,  $username,  $pwd,  $email);
}