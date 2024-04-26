<?php
function is_input_empty(string $username, string $pwd): bool{
    if(empty($username)|| empty($pwd) ){
        return true;
    }
    else {return false;}

}
function is_username_wrong(bool|array $result){
    #get_user( $pdo, $username, $password)
    if(!$result){ # if result == false, meaning username does not exist 
        return true;
    }
    else{
        return false;
    } 
}

function is_passsword_wrong(string $password, string $hashed_DB_PWD){
    #get_user( $pdo, $username, $password)
    #password_verify is a php built-in function.
    if(!password_verify($password, $hashed_DB_PWD)){ # if result == false, meaning username does not exist 
        return true;
    }
    else{
        return false;
    } 
}
