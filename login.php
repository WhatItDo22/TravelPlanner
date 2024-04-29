<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        p {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <?php
            if (isset($_POST["login"])) {
                $userDetail = $_POST["username"];   
                $password = $_POST["password"];

                $server = "localhost";
                $dbusername = "upjomg4jsiwwg";
                $dbpassword = "533%3611n_4`";
                $db = "dbz0xs4h1mcple";
                $conn = new mysqli($server, $dbusername, $dbpassword, $db);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }
                $sql = "SELECT * FROM users WHERE username = '$userDetail' OR email = '$userDetail'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result);

                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        $_SESSION["user"] = $user;
                        header("Location: default.php");
                        die();
                    } else {
                        echo "<div class='alert alert-danger'>Incorrect password</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Invalid username or email</div>";
                }
            }
        ?>
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="form-class">
                <input type="text" class="form-control" name="username" placeholder="Username or Email" required>
            </div>
            <div class="form-class">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-btn">
                <input type="submit" name="login" class="btn btn-primary" value="Login">
            </div>
        </form>
        <div>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>   

</body>
</html>