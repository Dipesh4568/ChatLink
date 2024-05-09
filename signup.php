<?php
    session_start();

    if(!isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatLink - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="image/logo1.png">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="cont w-400 p-5 shadow rounded">
    
    <form method="post" action="app/http/signup.php" enctype="multipart/form-data">
        
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="image/logo1.png" class="w-25">
            <h4 class="display-4 fs-1 text-center">Sign Up</h4>
        </div>
        <?php if(isset($_GET['error'])){ ?>
        <div class="alert alert-warning" role="alert" id="alert">
                <?php 
                $errorMessages = $_GET['error'];
                $errorMessages = urldecode($errorMessages); // Decode URL-encoded string
                $errorMessages = explode(" - ", $errorMessages); // Split error messages
                foreach ($errorMessages as $msg){
                    echo "<p class='mb-0'>" . htmlspecialchars($msg) . "</p>";
                }
                ?>
        </div>
            <?php } 
                
                if(isset($_GET['name'])){
                    $name = $_GET['name'];
                }else $name = '';

                if(isset($_GET['username'])){
                    $username = $_GET['username'];
                }else $username = '';

            ?>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= $name ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">User name</label>
            <input type="text" name="username" value="<?= $username ?>" class="form-control">
        </div>  

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div> 

        <div class="mb-3">
            <label class="form-label">Profile Picture</label>
            <input type="file" name="pp" class="form-control">
        </div>
  
         <button type="submit" class="btn btn-primary">Sign Up</button>
         <a href="index.php">Login</a>
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