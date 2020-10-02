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
    <?php include 'partials/_dbconnection.php';?>
    <?php include 'partials/_header.php'; ?>
    
    <!-- Displaying search results -->


    <div class="container" style="padding-left:16%; min-height:89vh;">
        <h1 class="py-3">Search Results For <em> "<?php echo $_GET['search'] ?>"</em></h1>
        <ul>
        
        <?php
        $noresult=true;
        $query=$_GET['search'];
        $query=str_replace("<","&lt;",$query);
        $query=str_replace(">","&gt;",$query);
        $sql = "SELECT * FROM `threads` where MATCH(thread_title,thread_description) against ('$query')";
        $result = mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
            $noresult=false;
            $title = $row['thread_title'];
            $desc = $row['thread_description'];
            $id = $row['thread_id'];

            echo '<div class="result " style="min-height: 100vh;">
                    <li><h3> <a href="threads.php?th_id='. $id .'" class="text-dark">'. $title .' </a></h3></li>
                    <p> '. $desc .' </p>
                    <hr></div></ul>';

        }
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h3 class="display-5">Your search - '. $query .' - did not match any documents.</h3>

                            Suggestions:
                            <ul>
                            
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                            </ul>
                         </div>
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