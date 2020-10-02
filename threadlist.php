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
    $id = $_GET['catid'];
    if(isset($_SESSION['uid'])){
        $user_id=$_SESSION['uid'];
    }
    $sql = "SELECT * FROM `categories` where category_id = $id";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];   
    }
     // inserting thread into database
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $thread_title=$_POST['title'];
        $thread_description=$_POST['description'];
        $thread_title=str_replace("<","&lt;",$thread_title);
        $thread_title=str_replace(">","&gt;",$thread_title);
        $thread_description=str_replace("<","&lt;",$thread_description);
        $thread_description=str_replace(">","&gt;",$thread_description);
        if($thread_description){
            $sql="INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_category`, `thread_user_id`) VALUES ('$thread_title', '$thread_description', '$id', '$user_id')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success.</strong> Your Problem has been successfully submitted.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
            }
        }
        else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Empty</strong> Your Thread Description is Empty. Please write something.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
     }
     
      


   
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome To <?php echo $catname ?></h1>
            <p class="lead"><?php echo $catdesc ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <!-- displaying threads or problems / fetching from database -->

    <div class="container">
        <h1 class="py-2">Discussion</h1>
        <?php
            $sql = "SELECT * FROM `threads` where thread_category=$id";
            $result = mysqli_query($conn,$sql);
            $nodata=true;
            
            while($row=mysqli_fetch_assoc($result)){
                $nodata=false;
                $title = $row['thread_title'];
                $desc = $row['thread_description'];
                $th_id = $row['thread_id'];
                $date = $row['thread_date'];
                $th_user_id = $row['thread_user_id'];
                $sql2 = "SELECT * FROM `users` where user_id ='$th_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2=mysqli_fetch_assoc($result2);
                $user_name = $row2['user_name'];
                echo '<div class="media my-2">
                            <img src="img/user.png" width=35px class="mr-3" alt="...">
                            <div class="media-body">
                            <p class="mb-1">'.$user_name.' at '.$date.'</p>
                            <h5 class="mt-0"><a href="/forum/threads.php?th_id='.$th_id.'">'. $title .'</a></h5>
                                '. $desc .'
                             </div>
                    </div>';
            }
            if($nodata==true){
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h3 class="display-5">No thread Available</h3>
                            <p class="lead">Be the first to start the discussion. </p>
                         </div>
                    </div>';
            }
              ?>
        <hr>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<h1>Post Thread Here</h1>
                <form class="my-2" action="'. $_SERVER['REQUEST_URI'] .'" method="post">
                    <div class="form-group">
                        <label for="title">Problem Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                        <small id="titleHelp" class="form-text text-muted">Keep the problem title as short as possible.</small>
                        <div class="form-group">
                            <label for="description">Problem Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>';
        
        }
        else{
            echo '<div class="container">
                    <p class="lead">You are not logged in. Login to start the Discussion</p>
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