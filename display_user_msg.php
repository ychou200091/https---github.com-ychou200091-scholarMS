<?php
function display_message(){
    if(isset($_SESSION["user_message"])){
        
        echo '<p>' . $_SESSION["user_message"] . '</p>';
        unset($_SESSION["user_message"]);
    }
}