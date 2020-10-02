<?php



if($_SERVER['REQUEST_METHOD']=='POST'){

    include '_dbconnection.php';
    $username=$_POST['usernameSignup'];
    $email=$_POST['emailSignup'];
    $password=$_POST['passwordSignup'];
    $cpassword=$_POST['cpasswordSignup'];
    //  Checking User deatils in Database/ Already Existed

    $ExistSql = "SELECT * from `users` where user_name='$username' ";
    $ExistResult = mysqli_query($conn,$ExistSql);
    $num = mysqli_num_rows($ExistResult);
    if($num>0){
        $showerror="Email already in use";
    }
    else{
        
        if($password==$cpassword){

            // inserting user details in Database

            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`,`user_email`,`user_password`) VALUES ('$username','$email','$hash')";
            $result = mysqli_query($conn,$sql);
            if($result){
                header("location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }

        else{
            $showerror="Passwords do not match";
        }
    }

    header("location: /forum/index.php?signupsuccess=false&error=$showerror");
    


}
?>