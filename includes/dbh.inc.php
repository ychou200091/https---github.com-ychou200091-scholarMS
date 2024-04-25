<?php   
$host = "localhost";
$dbname = "scholarMS";
$dsn = "mysql:host={$host};dbname={$dbname}";
$dbusername = "root";
$dbpass = "";

try{
    #pd0 is php data object
    $pd0 = new PDO($dsn, $dbusername, $dbpass);
    $pd0->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); # catch error with exception
    #$pd0->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    #$pd0->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


}catch(PDOException $e){
    # pdo connection error
    echo "Connection Failed: ". $e->getMessage() ."<br>";

}
