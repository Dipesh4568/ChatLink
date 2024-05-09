<?php
# check if username, password, name values are submitted

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])) {

    # database connection file
    include '../db.conn.php';

    # get data from POST superGlobal variable
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    # making URL data format
    $data = 'name=' . urlencode($name) . '&username=' . urlencode($username) . '&password=' . urlencode($password);

    # Accumulate error messages in a single variable
    $errorMessages = '';

    # Simple form validation
    if (empty($name)) {
        # error message for name
        $errorMessages .= "Name is required. - ";
    }

    if (empty($username)) {
        # error message for username
        $errorMessages .= "Username is required. - ";
    }

    if (empty($password)) {
        # error message for password
        $errorMessages .= "Password is required. - ";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        # error message for invalid password format
        $errorMessages .= "Password must be at least 8 characters long with at least one uppercase letter, one number, and one special character. - ";
    }

    if (!empty($errorMessages)) {
        # redirect to 'signup.php' and pass the error messages and data
        header("Location: ../../signup.php?error=" . urlencode($errorMessages) . "&$data");
        exit;
    } else {
        # checking the database if the username is taken
        $sql ="SELECT username FROM users WHERE username=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        if($stmt->rowCount() > 0){
            $em = "The username ($username) already exists";
            header("Location: ../../signup.php?error=$em&$data");
            exit;
        } else {
            # Profile Picture uploading
            if (isset($_FILES['pp']) && $_FILES['pp']['error'] === 0) {
                # get image and store them in vars
                $img_name = $_FILES['pp']['name'];
                $tmp_name = $_FILES['pp']['tmp_name'];

                # get image extension and store it in the variable $img_ex
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                
                # convert extension to lowercase
                $img_ex_lc = strtolower($img_ex);

                # acceptable extension for image
                $allowed_exs = array("jpg", "jpeg", "png");

                # checking if the file uploaded by the user has an extension according to the allowed ones by comparing with $allowed_exs
                if (in_array($img_ex_lc, $allowed_exs)) {
                    # store the uploaded image in USERNAME.$img_ex_lc format
                    $new_img_name = $username . '.' . $img_ex_lc;

                    # create the upload path on the root directory
                    $img_uploads_path = '../../uploads/' . $new_img_name;

                    # move the uploaded image to the ./uploads folder
                    move_uploaded_file($tmp_name, $img_uploads_path); 
                } else {
                    $em = "Allowed image types are jpg, jpeg, png";
                    header("Location: ../../signup.php?error=$em&$data");
                    exit;
                }
            }
            # password hashing with salt
            $password = password_hash($password, PASSWORD_DEFAULT);

            # inserting data into the database
            if(isset($new_img_name)){
                # inserting data with profile picture into the database
                $sql = "INSERT INTO users(name, username, password, p_p) VALUES(?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password, $new_img_name]);
            } else {
                # inserting data without profile picture into the database
                $sql = "INSERT INTO users(name, username, password) VALUES(?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $username, $password]);
            }

            # success message
            $sm = "Account created successfully";

            # redirect to the login page
            header("Location: ../../index.php?success=$sm");
            exit;
        }
    }
} else {
    header("Location: ../../signup.php");
    exit;
}
?>
