<?php 
require './config/database.php';

// get signup from data if signup button is clicked

if(isset($_POST['submit'])){

    $firstname = filter_var($_POST['firstname'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //validate input values

    // First validate if inputs are written or not
    if(!$firstname){
        $_SESSION['signup-error'] = "Please enter your First Name";
    } elseif(!$lastname){
        $_SESSION['signup-error'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['signup-error'] = "Please enter your UserName";
    }elseif(!$email){
        $_SESSION['signup-error'] = "Please enter your Email";
    }elseif( strlen($createpassword) < 8 || strlen($confirmpassword) < 8 ){
        $_SESSION['signup-error'] = "Please password should be 8+ characters";
    }elseif(!$avatar['name']){
        $_SESSION['signup-error'] = "Please add avatar";
    } else{
        // Validate if passwords don't match
        if($createpassword !== $confirmpassword){
            $_SESSION['signup-error'] = "Passwords do not match";
        } else{
          // If they match hash password
          $hashed_password = password_hash($createpassword , PASSWORD_DEFAULT);
          
          //check if username and email already exist in database
          $user_check_query = "SELECT * FROM users WHERE users_username='$username' OR users_email='$email'";
          $user_check_result = mysqli_query($connection , $user_check_query);
          if(mysqli_num_rows($user_check_result) > 0 ){
            $_SESSION['signup-error'] = "Username and Email already exist";
          } else{
            // work on avatar
            //rename avatar
            $time = time(); //make each image name unique
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = 'images/' . $avatar_name;

            //make sure file is an image
            $allowed_files = ['png' , 'jpg' , 'jpeg'];
            $extension = explode('.' , $avatar_name);
            $extension = end($extension);
            if(in_array($extension , $allowed_files)){
                //make sure image is not too large
                if($avatar['size'] < 1000000){
                    //upload avatar
                    move_uploaded_file($avatar_tmp_name , $avatar_destination_path);
                } else{
                    $_SESSION['signup-error'] = "File size is too big. Should be less than 1 mb";
                }
            } else {
                $_SESSION['signup-error'] = "File is not image";
            }
          }
        }
    }
    //redirect back to signup page if there was any problem
    if(isset($_SESSION['signup-error'])){
        //pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else{
        //insert new user into users table
        $insert_user_query = "INSERT INTO users (users_firstname , users_lastname , users_username , users_email , users_password , users_avatar , is_admin) VALUES ('$firstname' , '$lastname' , '$username' , '$email' , '$hashed_password' , '$avatar_name' , 0)";
        $insert_user_result = mysqli_query($connection , $insert_user_query);
        if(!mysqli_errno($connection)){
            // redirect to login page with success message
            $_SESSION['signup-success'] = "Registration successful. Please LogIn";
            header("location: " . ROOT_URL . "signin.php");
        }
    }
} else {
    // if button was not clicked get back to signup page
    header('location: ' . ROOT_URL . 'signup.php');
}