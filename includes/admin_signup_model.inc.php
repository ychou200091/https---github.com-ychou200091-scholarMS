<?php

# handling interacting database

declare(strict_types=1);

function get_username(object $pdo, string $username){
    $query = "SELECT username FROM admin_users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); #fect as associative array using column name instead of column index to refer to the array
    #echo "<p>fgjf" . $result . "</p>";
    return $result;
    
}

function get_email(object $pdo, string $email){
    $query = "SELECT email FROM admin_users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); #fetch as associative array using column name instead of column index to refer to the array
    #echo "<p>erere" . $result . "</p>";
    return $result;
    
}


function set_user(object $pdo, string $username, string $pwd, string $email){

    # hash pwd
    $options = ['cost' => 12];
    $hashedPWD = password_hash($pwd, PASSWORD_BCRYPT, $options);

    # Execute insert sql query
    $query = "INSERT INTO admin_users(username, email, password) VALUES (:username, :email, :password);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPWD);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); #fetch as associative array using column name instead of column index to refer to the array
    return $result;


}
