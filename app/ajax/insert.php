<?php
    session_start();

    # check if the user is logged in or not
    if(isset($_SESSION['username'])){

        if(isset($_POST['message']) && isset($_POST['to_id'])) {

        # database connection file
        include '../db.conn.php';
        
        # get data from XHR request and store them in variable
        $message =$_POST['message'];
        $to_id=$_POST['to_id'];

        # get the logged in user's ID from the $_SESSION
        $from_id = $_SESSION['user_id'];

        $sql = "INSERT INTO chats(from_id, to_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$from_id, $to_id, $message]);

        # If message inserted
        if($res){

            # checking if this is the first conversation
            $sql2 = "SELECT * FROM conversations WHERE (user_1=? AND user_2=?) OR (user_2=? AND user_1=?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);
            
            # setting up the time Zone
            # It depeneds on your location or device settings
            define('TIMEZONE', 'Africa/Addis_Ababa');
            date_default_timezone_set(TIMEZONE);
            
            $time = date("h:i:s a");

            if($stmt2->rowCount() == 0){
                # Inserting result in to conversations table
                $sql3 = "INSERT INTO conversations(user_1, user_2) VALUES(?, ?)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->execute([$from_id, $to_id]);
            }
            ?>

                <p class="rtext align-self-end border rounded p-2 mb-1"><?=$message?>
                    <small class="d-block"><?=$time?></small>
                </p>

            <?php
        }
    }
    }else{
        header("Location: index.php");
        exit;
    }
?>