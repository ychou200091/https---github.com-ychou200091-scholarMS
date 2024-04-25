<?php
error_reporting(1);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
   
    try{
        # compute sql query and check login match database
        require_once("dbh.inc.php");
        #require_once("login_view.inc.php");
        require_once("login_contr.inc.php");
        require_once("login_model.inc.php");
        $errors = [];
        if(is_input_empty($username, $password)){
            $errors["empty_fields"] = "Please enter all fields";
        }

        $result = get_user($pd0, $username);
        
        if(is_username_wrong($result)){
            $errors["unknown_username"] = "Unknown username, please sign-up first.";
        }
        if( !is_username_wrong($result) && is_passsword_wrong( $password, $result["password"])){
            $errors["incorrect_password"] = "Incorrect password.";
        }

        require_once("config.php");

        if($errors){
            
            $_SESSION["errors_login"] = $errors;
            #session_regenerate_id();
            
            header("Location: ../index.php");
            die();
        }
        #require_once("config.php");
        #update session info, set login-user
        $new_session_id = session_create_id();
        $session_id = $new_session_id . "_".$result["user_id"];
        session_id($session_id);
        
        $_SESSION["user_id"] = $result["user_id"] ;
        $_SESSION["username"] = htmlspecialchars($result["username"] );
        $_SESSION["last_regeneration"] = time();
        header("Location: ../index.php?login=success");
        $pd0 = null;
        $stmt = null;
        die();
        
    }catch(PDOException $e){
        die("Query Failed: " .$e->getMessage());
    }


}else{
    header("Location: ../index.php");
    die();
}