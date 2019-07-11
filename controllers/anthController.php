<?php

session_start();

require 'config/server.php';

$errors = array();
$username = "";
$email = "";

// if user clicks on the sign up button
if (isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    // validation
    if (empty($username)) {
        $errors['username'] = "Username required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){        
        $errors['email'] = "Email address is invalid";
    }
    if (empty($email)) {
        $errors['email'] = "Email required";
    }

    if (empty($password)) {
        $errors['password'] = "Password required";
    }
    if($password != $passwordConf){
        $errors['password'] = "the two password do not match";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $statment = $conn->prepare($emailQuery);
    $statment->bind_param('s', $email);
    $statment->execute();
    $result = $statment->get_result();
    $userCount = $result->num_rows;
    $statment->close();

    if($userCount > 0){
        $errors['email'] = "Email already exists";
    }

    if(count($errors) === 0){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, verified, token, password) VALUES (?, ?, ?, ?, ?)";
        $statment = $conn->prepare($sql);
        $statment->bind_param('ssbss', $username, $email, $verified, $token, $password);

        if($statment->execute()){
            // login user
            $user_id = $conn->insert_id;
            
        }else{
            $errors['db_error'] = "Database error: failed to register";
        }
    }

}