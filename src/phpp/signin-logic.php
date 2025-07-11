<?php 
require './config/database.php';
if(isset($_POST['submit'])){

$username_email = filter_var($_POST['username_email'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_var($_POST['password'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(!$username_email){
    $_SESSION['signin-error'] = "Username or Email is required";
} elseif (!$password){
    $_SESSION['password'] = "Password is required";
} else {
    //fetch user from database
    $fetch_user_query = "SELECT * FROM users WHERE users_username='$username_email' OR users_email='$username_email'";
    $fetch_user_result = mysqli_query($connection , $fetch_user_query);

    if(mysqli_num_rows($fetch_user_result) == 1){
        // convert the record into assoc array
        $user_record = mysqli_fetch_assoc($fetch_user_result);
        $db_password = $user_record['users_password'];
        // compare form password with database password
        if(password_verify($password , $db_password)){
            // set session for access control
            $_SESSION['user_id'] = $user_record['users_id'];
            //set session if user is an admin
            if($user_record['is_admin'] == 1 ){
                $_SESSION['user_is_admin'] = true;
            }

            //log user in
            header('location: ' . ROOT_URL . 'admin/');
        } else{
            $_SESSION['signin-error'] = "Please check your password";
        }
    } else{
        $_SESSION['signin-error'] = "User not found";
    }
}

//if any problem occured redirect back to dignin page with login data
if(isset($_SESSION['signin-error'])){
    $_SESSION['signin-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}


} else{
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}