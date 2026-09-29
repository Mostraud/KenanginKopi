<?php
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['delete_user'])) {
    $idToDelete = $_POST['user_id'];
    mysqli_query($conn, "DELETE FROM Users WHERE UserID = '$idToDelete'");
}

$query = "SELECT * FROM Users WHERE UserRole = 'User'"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head> <title>Manage User</title> <link rel="stylesheet" href="style.css"> </head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Manage User</h2>
        <table class="table-cart">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['UserID']; ?></td>
                    <td><?php echo $row['FullName']; ?></td>
                    <td><?php echo $row['UserName']; ?></td>
                    <td><?php echo $row['UserEmail']; ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="user_id" value="<?php echo $row['UserID']; ?>">
                            <button type="submit" name="delete_user" class="btn-delete">Delete</button> </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>