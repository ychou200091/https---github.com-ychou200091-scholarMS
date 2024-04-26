<?php
function display_message(){
    if(isset($_SESSION["conf_message"])){
        echo '<p>'.$_SESSION["conf_message"].'<\p>';
        unset($_SESSION["conf_message"]);
    }
}