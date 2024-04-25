<?php
$pwd_signup = "myPassword";

$options = ["cost" => 12 ];

#built-in function on hashing
# php does salt for you
$hashed_password = password_hash($pwd_signup,$PASSWORD_BCRYPT,$options); 

#then inject into sql

# then when user try to login, verify user's enter.
$pwd_login = "myPassword";
if( password_verify($pwd_login, $hashed_password)){
    echo "<p>Login Successful</p>";
} else{
    echo "<p>Login failed</p>";
}