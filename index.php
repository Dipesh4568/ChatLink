<?php
    session_start();

    if(!isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatLink - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="image/logo1.png">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="cont w-400 p-5 shadow rounded">
    
    <form method="post" action="app/http/auth.php">
        
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="image/logo1.png" class="w-25">
            <h4 class="display-4 fs-1 text-center">LOGIN</h4>
        </div>

        <?php if(isset($_GET['error'])) { ?>
            <div class="alert alert-warning" role="alert" id="alert"> 
                <?php 
                    $errorMessage = $_GET['error'];
                    $errorMessage = urldecode($errorMessage); //Decode URL-enoded String
                    $errorMessage = explode (" - ", $errorMessage); // split error message
                    foreach($errorMessage as $em){
                        echo "<p class='mb-0'>". htmlspecialchars($em) . "</p>";
                    }
                ?>
            </div>
        <?php } ?>

        <?php if(isset($_GET['success'])){ ?>
            <div class="alert alert-success" role="alert">
                <?php 
                    $successMessages = $_GET['success'];
                    $successMessages = urldecode($successMessages); // Decode URL-encoded string
                    $successMessages = explode(" - ", $successMessages); // Split error messages
                    foreach ($successMessages as $msg){
                        echo "<p class='mb-0'>" . htmlspecialchars($msg) . "</p>";
                    }
                ?>
            </div>
        <?php } ?>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
        </div>   
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div> 
  
         <button type="submit" class="btn btn-primary">LOGIN</button>
         <a href="signup.php">Sign up</a>
    </form>
    </div>
</div>
</body>
</html>
<?php 
    }else{
        header("Location: home.php");
        exit;
    }
?>