<?php
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}

if (isset($_POST['delete_store'])) {
    $id = $_POST['store_id'];
    if(mysqli_query($conn, "DELETE FROM Store WHERE StoreID = '$id'")) {
        echo "<script>alert('Store deleted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to delete store.');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM Store");
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Manage Store - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 style="margin: 0; color: #5c4033;">Manage Store</h2>
                
                <a href="add_store.php" class="btn-login" style="text-decoration: none;">+ Add Store</a>
            </div>

            <table class="table-cart">
                <thead>
                    <tr>
                        <th>Store ID</th>
                        <th>Store Name</th>
                        <th>Location</th>
                        <th style="text-align: center;">Coffee</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><b><?php echo $row['StoreID']; ?></b></td>
                            <td><?php echo $row['StoreName']; ?></td>
                            <td><?php echo $row['StoreLocation']; ?></td>
                            
                            <td style="text-align: center;">
                                <a href="manage_coffee.php?store_id=<?php echo $row['StoreID']; ?>" class="btn-small" style="text-decoration: none;">
                                    Manage
                                </a>
                            </td>
                            
                            <td style="text-align: center;">
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this store? All coffee menus in it will also be deleted.');">
                                    <input type="hidden" name="store_id" value="<?php echo $row['StoreID']; ?>">
                                    <button type="submit" name="delete_store" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                                No stores available. Please add a store.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
        </div> 
    </div> 
<?php include 'footer.php'; ?>
</body>
</html>