<?php
include 'connection.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$userID = $_SESSION['user_id'];
$msg = "";

$query = "SELECT * FROM Users WHERE UserID = '$userID'";
$user = mysqli_fetch_assoc(mysqli_query($conn, $query));

if (isset($_POST['save'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (empty($username) || empty($email)) {
        $msg = "Fields cannot be empty.";
    } elseif (!ctype_alpha($username)) {
        $msg = "Username must be Alphabetic only.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid Email format.";
    } else {
        $cekEmail = mysqli_query($conn, "SELECT * FROM Users WHERE UserEmail='$email' AND UserID != '$userID'");
        if (mysqli_num_rows($cekEmail) > 0) {
            $msg = "Email is already taken by another user.";
        } else {
            $update = "UPDATE Users SET UserName='$username', UserEmail='$email' WHERE UserID='$userID'";
            if (mysqli_query($conn, $update)) {
                $_SESSION['username'] = $username;

                echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
                exit();
            } else {
                $msg = "Update failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Edit Profile - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="auth-wrapper">
        
        <div class="auth-box">
            <h2>Edit Profile</h2>
            
            <?php if($msg): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $user['UserName']; ?>" class="input-field">

                <label>Email</label>
                <input type="text" name="email" value="<?php echo $user['UserEmail']; ?>" class="input-field">

                <button type="submit" name="save" class="btn-login" style="margin-top: 10px;">Save Changes</button>
            </form>
            
            <br>
            <a href="profile.php" style="text-decoration: none; color: #666; font-size: 14px;">← Back to Profile</a>
        </div>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>