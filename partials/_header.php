<script>
    let date;
    // let time;
    let a;
    const options = {weekly:'long',year:'numeric',month:'long',day:'numeric'};
    setInterval(()=>{
        a = new Date();
        date = a.toLocaleDateString(undefined,options);
        // time = a.getHours()+':'+ a.getMinutes()+':'+a.getSeconds();
        document.getElementById('time').innerHTML=date;

    },1000)

</script>

<?php
session_start();



echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/forum/index.php">iDiscuss</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="/forum/index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">About</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       Top Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    $sql = "SELECT * FROM `categories` LIMIT 3";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catid = $row['category_id'];
        echo '<a class="dropdown-item" href="threadlist.php?catid='.$catid.'">'. $catname .'</a>';
    }

      echo '</div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Contact</a>
    </li>
  </ul>';
  

  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '<form class="form-inline my-2 my-lg-0 " method="get" action="search.php">
      
    <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success my-1 my-sm-0" type="submit">Search</button>
    </form>
    <p class="text-light align-center my-0 mx-3">Welcome '. $_SESSION['username'] .'
    <a href="partials/_logout.php" class="btn btn-outline-success ml-2" type="submit">Logout</a>';
  }
  else{
    echo '<form class="form-inline my-2 my-lg-0 " method="get" action="search.php">
              <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-success my-1 my-sm-0" type="submit">Search</button>
          </form>
          <button class="btn btn-outline-success my-sm-0 ml-1 mr-2" data-toggle="modal" data-target="#loginModal" type="submit">Login</button>
          <button class="btn btn-outline-success my-sm-0 mr-2"  data-toggle="modal" data-target="#signupModal"type="submit">Sign Up</button>';
  }

  echo '<p id="time" class="text-light my-2"></p>
        </div>
        </nav>';


include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']==true){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong> Registration Sucessfull. </strong> You can now Login.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

if(isset($_GET['loginerror']) && $_GET['loginerror']==true){
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
            <strong> Invalid Credentials.</strong> Check username or password.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

?>