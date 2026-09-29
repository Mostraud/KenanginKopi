<?php
include 'connection.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$userID = $_SESSION['user_id'];
$query = "SELECT * FROM Users WHERE UserID = '$userID'";
$user = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box" style="max-width: 600px;"> <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
                <h2 style="margin: 0; color: #5c4033;">My Profile</h2>
                <p style="margin: 5px 0 0 0; color: #888; font-size: 14px;">Manage your account details</p>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="padding: 15px 0; color: #666; width: 140px;">User ID</td>
                    <td style="padding: 15px 0; font-weight: bold; color: #333;"><?php echo $user['UserID']; ?></td>
                </tr>
                
                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="padding: 15px 0; color: #666;">Full Name</td>
                    <td style="padding: 15px 0; font-weight: bold; color: #333;"><?php echo $user['FullName']; ?></td>
                </tr>

                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="padding: 15px 0; color: #666;">Username</td>
                    <td style="padding: 15px 0; font-weight: bold; color: #333;"><?php echo $user['UserName']; ?></td>
                </tr>

                <tr>
                    <td style="padding: 15px 0; color: #666;">Email</td>
                    <td style="padding: 15px 0; font-weight: bold; color: #333;"><?php echo $user['UserEmail']; ?></td>
                </tr>
            </table>

            <div style="display: flex; gap: 10px;">
                <a href="edit_profile.php" class="btn-login" style="text-decoration: none;">Edit Profile</a>
                <a href="history.php" class="btn-login" style="text-decoration: none; background-color: #6c757d;">Order History</a>
            </div>

            <div style="margin-top: 25px;">
                <a href="index.php" style="color: #888; text-decoration: none; font-size: 14px;">← Back to Home</a>
            </div>

        </div> 
    </div> 
<?php include 'footer.php'; ?>
</body>
</html>