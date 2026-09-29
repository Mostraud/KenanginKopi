<?php
include 'connection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = ""; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (empty($username) || empty($password)) {
        $error = "Username and Password must be filled.";
    } else {
        $query = "SELECT * FROM Users WHERE UserName = '$username' AND UserPassword = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['UserName'];
            $_SESSION['role'] = $row['UserRole'];

            if ($remember) {
                setcookie('user_session', $row['UserID'], time() + (7 * 24 * 60 * 60), "/");
            }

            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid Credentials";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="auth-wrapper">
        
        <div class="auth-box">
            <h2>Login</h2>
            
            <?php if($error != ""): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" class="input-field" placeholder="Enter username">

                <label>Password</label>
                <input type="password" name="password" class="input-field" placeholder="Enter password">

                <div style="text-align: left; margin-bottom: 20px;">
                    <input type="checkbox" name="remember" id="rem"> 
                    <label for="rem" style="display:inline; font-weight:normal;">Remember Me</label>
                </div>

                <button type="submit" name="login" class="btn-login">Login</button>
            </form>

            <br>
            <p>Don't have an account? <a href="register.php" style="color: #c49a6c; font-weight: bold;">Register here!</a></p>
        </div>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>