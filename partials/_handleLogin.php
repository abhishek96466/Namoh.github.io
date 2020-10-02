<?php



if($_SERVER['REQUEST_METHOD']=='POST'){

    include '_dbconnection.php';
    $username=$_POST['usernameLogin'];
    $password=$_POST['passwordLogin'];
    //  Checking User deatils in Database/ Already Existed

    $sql = "SELECT * from `users` where user_name='$username' ";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if($num==1){
        while($row=mysqli_fetch_assoc($result)){
        $uid=$row['user_id'];
        if(password_verify($password,$row['user_password'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['username']=$username;
            $_SESSION['uid']=$uid;
            header("location: /forum/index.php");
            exit();
        }}     
    }

    header("location: /forum/index.php?loginerror=true");
    


}
?>