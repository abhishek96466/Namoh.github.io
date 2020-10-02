<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>iDiscuss</title>
</head>

<body>
    <?php include 'partials/_dbconnection.php';
    include 'partials/_header.php'; ?>
    <?php 
    $id = $_GET['th_id'];
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }

    // fetching thread from the database
    $sql = "SELECT * FROM `threads` where thread_id = $id";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $thread_title = $row['thread_title'];
        $thread_desc = $row['thread_description']; 
        $thread_user_id = $row['thread_user_id'];
    }
    // fetching user from database
    $sql2 = "SELECT * FROM `users` where user_id = $thread_user_id";
    $result2 = mysqli_query($conn,$sql2);
    $row = mysqli_fetch_assoc($result2);
    $user_name=$row['user_name'];


     // inserting Comments into database
     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $comment_content=$_POST['comment'];
        $thread_id=$id;
        $comment_content=str_replace("<","&lt;",$comment_content);
        $comment_content=str_replace(">","&gt;",$comment_content);
        if($comment_content){
            $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment_content', '$id', '$username')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> Your Comment has been successfully Posted.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
        else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Empty</strong> Your comment box is Empty. Please write something.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }
    
        
     }

    ?>
    <!-- displaying the Thread -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $thread_title ?></h1>
            <p class="lead"><?php echo $thread_desc ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p><b>Posted by - <?php echo $user_name; ?></b></p>
        </div>
    </div>

    <!-- displaying the comments -->
    <div class="container">
        <h1 class="py-2">Comments</h1>
        <?php
            $sql = "SELECT * FROM `comments` where thread_id=$id";
            $result = mysqli_query($conn,$sql);
            $nodata=true;
            while($row=mysqli_fetch_assoc($result)){
                $nodata=false;
                $comment_by = $row['comment_by'];
                $comment_content = $row['comment_content'];
                $comment_date = $row['comment_date'];
                echo '<div class="media my-2">
                            <img src="img/user.png" width=35px class="mr-3" alt="...">
                            <div class="media-body">
                            
                            <h5 class="mt-0">'. $comment_by .'</a></h5>
                                '. $comment_content .'
                             </div>
                    </div>';
            }
            if($nodata==true){
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h3 class="display-5">No Comments Available</h3>
                            <p class="lead">Be the first to start the discussion. </p>
                         </div>
                    </div>';
            }
        ?>

        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<hr>
                    <h1>Post a Comment</h1>
                    <form class="my-2" action="'.$_SERVER['REQUEST_URI'].'" method="post">
                        <div class="form-group">
                            <label for="description">Post a Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Post Comment</button>
                    </form>';
        }
        else{
            echo '<div class="container">
                    <p class="lead">You are not logged in. Login to Post a Comment.</p>
                  </div>';
        }
        ?>
    </div>

    <?php   include 'partials/_footer.php'; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>