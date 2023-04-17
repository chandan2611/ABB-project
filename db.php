<?php
$servername  ="localhost:3306";
$dbname = "rest_login";
$userName = " root";
$password = "Parameshwar@0511";
//create connection

$conn = mysqli_connect($servername, $userName, $password, $dbname);

if(mysqli_connect _errno()){
    //http_response_code(400);
    //header('Content-type: text/plain');
    echo "failed to connect!";
    exit();
}
echo"connection success1";

?>