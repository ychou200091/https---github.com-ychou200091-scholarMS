<?php   

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $options = ["cost" => 12 ];
    $hashed_password = password_hash($password,$PASSWORD_BCRYPT,$options); # auto salt

    try{
        require_once("dbh.inc.php");
        
        require_once("signup_model.inc.php");
        require_once("signup_view.inc.php");
        require_once("signup_contr.inc.php");
        #require_once("config.php");


        $query = "INSERT INTO users (username,password,email) VALUES (:username,:pwd,:email);";
        # username,$password,$email
        $errors = [];

        if(is_input_empty($username,$password, $email)){
            $errors["empty_input"] = "Fill in all the fields.";
        }
        if(is_email_invalide($email)){ # invalid email
            $errors["email_invalid"] = "Enter a valid email.";
        }
        if(is_email_regiestered($pd0, $email)){
            $errors["email_taken"] = "Email taken.";
        }
        if(is_username_taken($pd0,  $username)){ # invalid email
            $errors["username_taken"] = "Username taken.";
        } 
        # check input error
        if($errors){
            require_once("config.php");
            $_SESSION["errors_signup"] = $errors;
            // foreach($_SESSION["errors_signup"] as $error){
            //     echo '<p class="form-error">Error: ' . $error .'</p>';
            // }

            $signup_data = ["username" => $username, "email" => $email];
            $_SESSION["signup_data"] = $signup_data;
            header("Location: ../index.php");
            die();
        }
        else{
            echo "<p>no errors</p>";
        }
        create_user($pd0, $username, $password, $email);
      
        $pd0=null;
        $stmt = null;
        header("Location: ../index.php?signup=success");
        die();

    }catch(PDOException $e){
        # pdo connection error
        echo "Connection Failed: ". $e->getMessage();
        die("Query Failed: " . $e->getMessage() );
    }

}else{
    header("Location: ../index.php");
    die();
}

