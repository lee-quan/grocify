<?php require "../template/connect.php" ?>

<?php
if (isset($_POST["register"])) {
    $name = $email = $password = $cpassword = "";
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if ($password == $cpassword) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $insert = $link->query("INSERT INTO admin (email,name,password,status) VALUES ('$email','$name','$param_password',0)");
        if ($insert) {
            echo "<script type='text/javascript'>alert('submitted successfully!');
            window.location.href='login.php';</script>";
        }
    }
}

if (isset($_POST["login"])) {
    $email = $password = "";
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id,email,password,name FROM admin WHERE email='$email'";
    if ($retrieve = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($retrieve)) {
            mysqli_stmt_store_result($retrieve);

            if (mysqli_stmt_num_rows($retrieve) == 1) {
                mysqli_stmt_bind_result($retrieve, $id, $email, $hashed_password,$name);
                if (mysqli_stmt_fetch($retrieve)) {
                    if (password_verify($password, $hashed_password)) {
                        // correct password, start the session
                        session_start();
                        //store data in session variable
                        $_SESSION["loggedin"] = true;
                        $_SESSION["adminid"] = $id;
                        $_SESSION["adminemail"] = $email;
                        $_SESSION["adminname"] = $name;
                        // Redirect to homepage
                        header("location: index.php");
                    } else {
                        // Password is not valid, display a generic error message
                        $login_err = "Invalid email or password.";
                    }
                }
            } else {
                // email doesn't exist, display a generic error message
                $login_err = "Invalid email or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($retrieve);
    }
}

?>