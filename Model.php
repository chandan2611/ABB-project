<?php
header("Access-Control-Allow-Origin: http://localhost:3306");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST,PATCH, DELETE ");

include_once "./db.php";
include_once "./helers.php";


if ($_SERVER['REQUEST_METHOD'] == "POST " && !isset($_POST['crud_req']) )
logout($conn);

if($_SERVER['REQUEST_METHOD']=="POST" && $_POST['crud_req']== "sign up")
signup($conn);

if ($_SERVER['REQUEST_METHOD'] == "PATCH");
update($conn);

if ($_SERVER['REQUEST_METHOD'] == " DELETE");
unsubscribe($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST"&& $_POST['crud_req']== "login")
login($conn);

function signup ($conn){
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $userName = $_POST['userName'];
    $fName = $_POST['email'];
    $pwd = $_POST['pwd'];
    $rPwd = $_POST['rPwd'];

    session_start();

    if(empty($fname) || empty($lName) || empty($userName) || empty($email) || empty($pwd))
        sendReply(400, "All fields are mandatory!!!");
        
    
    if (! filter_var($email, FILTER_VALIDATE_EMAIL))
        sendReply(400,  "Invalid Email Address !!!");
       

    if($pwd ! = $rPwd)
        sendReply(400, "Inconsistent Passwords!!!");
        
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    $rPwd = $pwd;


    $sql = "Insert into uses (first_name, last_name, user_name, email, pwd, r_pwd) values(?,?,?,?,?,?,)"
    $stmt= $conn -> stmt_init();

    if (stmt ->prepare($sql))
        sendReply(400"Something went wrong!!!");
       
   
    $stmt->bind_param('ssssss', $fName, $lName, $userName, $email, $pwd, $rPwd);
    $stmt->execute();
    if(stmt->affected_rows > 0)
        sendReply(2, "Congratulations!! \n You have been successfully registered.");
    else
    sendReply(400"Something went wrong.");

}
function login ($conn){
    $userName = $_POST['userName'];
    $pwd = $_POST['pwd'];
   

    if(empty($fname) || empty($pwd))
        sendReply(400, "All fields are mandatory!!!");

    $sql= "select pwd from users where user_name?;";
    $stmt= $conn -> stmt_init();
    if(!$stmt->prepare($sql))
    sendReply(400, "Something went wrong. Try again later !!!");
    $stmt -> bind_param ('s', $userName);
    $stmt -> execute();
    $result = $stmt -> get_result();
    if (mysqli_num_rows($result) > 0){
        //..........
        $data = $result -> fetch_assoc();
        $isValid = password_verify($pwd, $data['pwd']);
        if (!$isValid)
        sendReply(400, "Invalid username or password");
        session_start();
        $_SESSION['user']= $userName;
        sendReply(200, "Welcome". $_SESSION ['user']);

    }
    else
    sendReply(400,"Invalid username or password");

}
function logout ($conn){
    if(!isset($_SESSION['user']))
    sendReply(400, "you are not logged in");
    unset($_SESSION['user'])
    session_destroy();
    sendReply(200, "You are not logged out");

}
function update ($conn){
    if(!isset($_SESSION['user']))
    sendReply(400, "you are not logged in");

    parse_str(file_get_contents("php://input"),$_PATCH );


        $fName = $_PATCH['fName'];
        $lName = $_PATCH['lName'];
        $userName = $_PATCH['userName'];
        $fName = $_PATCH['email'];
        $pwd = $_PATCH['pwd'];
        $rPwd = $_PATCH['rPwd'];
    
        session_start();
    
        if(empty($fname) || empty($lName) || empty($userName) || empty($email) || empty($pwd))
            sendReply(400, "All fields are mandatory!!!");
            
        
        if (! filter_var($email, FILTER_VALIDATE_EMAIL))
            sendReply(400,  "Invalid Email Address !!!");
           
    
        if($pwd ! = $rPwd)
            sendReply(400, "Inconsistent Passwords!!!");
            
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $rPwd = $pwd;
    
    
        $sql = "update users set first_name=?, last_name=?, user_name+?, email=?, pwd+?, r_pwd=? where user_name=? "
        $stmt= $conn -> stmt_init();
    
        if (stmt ->prepare($sql))
            sendReply(400"Something went wrong!!!");
       
        $stmt->bind_param('sssssss', $fName, $lName, $userName, $email, $pwd, $rPwd, $_SESSION['user'])
        $stmt->execute();
        if(stmt->affected_rows > 0)
        {
            $_SESSION['user'] = $userName;
            sendReply(2, "Congratulations!! \n You have been successfully updated your details.");
        }
        else
        sendReply(400"Something went wrong. Try again later ");
    
    }

function unsubscribe ($conn){
    if(!isset($_SESSION['user']))
    sendReply(403, "You are not authorzed to perform the operation.");

    $sql= "Delete form users where user_name ='".$_SESSION['user']."';";


    if($conn->query($sql))
    {
        unset($_SESSION['user']);
        session_destroy();
        sendReply(200, "You are no longer a registered member with us.");
    
    }
    else
    sendReply(400, "Something went wrong, try again later");

}

