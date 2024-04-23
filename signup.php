<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
    </style>
</head>
<body>
    <div class="signup-container">
        <form action="signup.php" method="post">
            <div class="form-class">
                <input type="text" class="form-info" name="username" placeholder="Username" required>
            </div>
            <div class="form-class">
                <input type="text" class="form-info" name="email" placeholder="Email" required>
            </div>
            <div class="form-class">
                <input type="text" class="form-info" name="password" placeholder="New Password" required>
            </div>
            <div class="form-class">
                <input type="text" class="form-info" name="repeat_password" placeholder="Repeat Password" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Sign Up">
            </div>
        </form>
    </div>
</body>
</html>