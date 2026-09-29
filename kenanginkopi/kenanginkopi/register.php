<?php
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields must be filled.";
    } 

    elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $error = "Full Name must be alphabetic characters and spaces only.";
    }

    elseif (!ctype_alpha($username)) {
        $error = "Username must be alphabetic only.";
    }
    elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $error = "Password must be min 8 chars, include 1 uppercase, 1 lowercase, 1 number.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    elseif (preg_match("/^[\.@]|[\.@]@|@[\.@]|[\.@]$|\.\./", $email)) {
        $error = "Email violates placement rules (check dots and @).";
    }
    else {
        $checkEmail = mysqli_query($conn, "SELECT * FROM Users WHERE UserEmail = '$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            $error = "Email is already registered.";
        } else {
            $newID = "U" . rand(1000, 9999);
            $role = 'User'; 
            $insert = "INSERT INTO Users VALUES ('$newID', '$fullname', '$username', '$email', '$password', '$role')";
            
            if (mysqli_query($conn, $insert)) {
                echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
                exit();
            } else {
                $error = "Register failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="auth-wrapper">
        
        <div class="auth-box">
            <h2>Register</h2>
            
            <?php if($error != ""): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>Full Name</label>
                <input type="text" name="fullname" class="input-field" placeholder="Enter full name">

                <label>Username</label>
                <input type="text" name="username" class="input-field" placeholder="Enter username">

                <label>Email</label>
                <input type="text" name="email" class="input-field" placeholder="Enter email address">

                <label>Password</label>
                <input type="password" name="password" class="input-field" placeholder="Enter password">

                <button type="submit" name="register" class="btn-login">Register</button>
            </form>

            <br>
            <p>Already have an account? <a href="login.php" style="color: #c49a6c; font-weight: bold;">Login here</a></p>
        </div>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>