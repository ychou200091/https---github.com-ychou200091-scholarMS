<?php   

// echo "<p>Session status: " . session_status() . "</p>";

if(session_status() == 0 || session_status() == 1){
    session_start();
}


#echo "<p>Session status: " . session_status() . "</p>";
ini_set("session.use_only_cookies",1); # avoid cross-site scripting
ini_set("session.use_strict_mode",1); # mandatory for session security.
# checking cookie settings
session_set_cookie_params( 
    ["lifetime" => 1800,
    "domain" => "localhost",
    "path" => "/", # allow running cookie in any subdirectory
    "secure" => true, # only allow https connections
    "httponly" => true, # prevent javascript modification
    ]
);
// echo "<p>Session status: " . session_status() . "</p>";
// if (!is_writable(session_save_path())) {
//     echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
// }else{
//     echo 'Session path "'.session_save_path().'" is writable for PHP!'; 
// }

// if(isset($_SESSION["user_id"])){
//     echo "<p>user_id: " . $_SESSION["user_id"] . "</p>";
// }
// if(isset($_SESSION["username"])){
//     echo "<p>username: " . $_SESSION["username"] . "</p>";
// }
//echo "<p>Session status: " . session_status() . "</p>";


$interval = 60*30; # 30 minutes

# Goal: regenerate session cookie periodically for security
if(isset($_SESSION['user_id'])){ # case1: login successful
    if(!isset($_SESSION["last_regeneration"])){ # init session with a secure id.
        // echo "<p> regenerate_session_id111</p>";
        regenerate_session_id_login();
    }else{ # regenerate session id periodically
        // echo "<p> regenerate_session_id_login</p>";
        if(time() - $_SESSION["last_regeneration"] >= $interval) { 
            regenerate_session_id_login();
        }
    }
}
else { # case2: not login yet
    if(!isset($_SESSION["last_regeneration"])){ # init session with a secure id.
        // echo "<p> regenerate_session_id</p>";
        regenerate_session_id();
    }else{ # regenerate session id periodically
        // echo "<p> update last_regeneration</p>";
        if(time() - $_SESSION["last_regeneration"] >= $interval) { 
            regenerate_session_id();
        }
    }
}
function regenerate_session_id_login(){
    $new_session_id = session_create_id();
    $session_id = $new_session_id . "-".$_SESSION['user_id'];
    session_id($session_id);
    
    $_SESSION["last_regeneration"] = time();
    // echo "<p>session restarted</p>";

}

function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();

}
