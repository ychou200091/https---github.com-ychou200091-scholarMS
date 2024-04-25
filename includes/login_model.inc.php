<?php
declare (strict_types= 1);

function get_user(object $pdo, string $username){
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); #fect as associative array using column name instead of column index to refer to the array
    echo '<p>.'.var_dump($result).'</p>';
    
    return $result;

}