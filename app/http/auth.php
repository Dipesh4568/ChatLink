<?php  
session_start();

# check if username & password  submitted
if(isset($_POST['username']) && isset($_POST['password'])){

   # database connection file
   include '../db.conn.php';
   
   # get data from POST request and store them in variables
   $password = $_POST['password'];
   $username = $_POST['username'];
   
   $em = '';
   # simple form validation
   if(empty($username)){
      # error message
      $em .= "Username is required. - ";
   }
   if(empty($password)){
      # error message
      $em .= "Password is required. - ";
   }

   if(empty($em)){
      $sql  = "SELECT * FROM users WHERE username=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);

      # if the username exists
      if($stmt->rowCount() === 1){
        # fetching user data
        $user = $stmt->fetch();

        # if both usernames are strictly equal
        if ($user['username'] === $username) {
           
           # verifying the password
          if (password_verify($password, $user['password'])) {

            # successfully logged in
            # creating the SESSION
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];

            # redirect to 'home.php'
            header("Location: ../../home.php");
            exit;

          } else {
            # error message
            $em = "Incorrect Username or password";

            # redirect to 'index.php' and pass error message
            header("Location: ../../index.php?error=$em");
            exit;
          }
        } else {
          # error message
          $em = "Incorrect Username or password";

          # redirect to 'index.php' and pass error message
          header("Location: ../../index.php?error=$em");
          exit;
        }
      }
   } else {
    # redirect to 'index.php' and pass the error messages
    header("Location: ../../index.php?error=" . urlencode($em));
    exit;
   }
} else {
  header("Location: ../../index.php");
  exit;
}
