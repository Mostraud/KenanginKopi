<?php
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}

if (!isset($_GET['store_id'])) { 
    header("Location: manage_store.php"); 
    exit(); 
}
$storeID = $_GET['store_id'];

if (isset($_POST['delete_coffee'])) {
    $coffeeID = $_POST['coffee_id'];
    mysqli_query($conn, "DELETE FROM Coffee WHERE CoffeeID = '$coffeeID'");
}

$query = "SELECT c.*, sc.Price FROM Coffee c 
          JOIN StoreCoffee sc ON c.CoffeeID = sc.CoffeeID 
          WHERE sc.StoreID = '$storeID'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Manage Coffee - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <div>
                    <h2 style="margin: 0; color: #5c4033;">Manage Coffee</h2>
                    <p style="margin: 5px 0 0 0; color: #666;">Store ID: <b><?php echo $storeID; ?></b></p>
                </div>
                
                <a href="add_coffee.php?store_id=<?php echo $storeID; ?>" class="btn-login" style="text-decoration: none;">+ Add Coffee</a>
            </div>

            <table class="table-cart">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><b><?php echo $row['CoffeeID']; ?></b></td>
                            <td><?php echo $row['CoffeeName']; ?></td>
                            <td>Rp <?php echo number_format($row['Price'], 0, ',', '.'); ?></td>
                            <td style="font-size: 14px; color: #555;"><?php echo $row['CoffeeDesc']; ?></td>
                            <td style="text-align: center;">
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this coffee?');">
                                    <input type="hidden" name="coffee_id" value="<?php echo $row['CoffeeID']; ?>">
                                    <button type="submit" name="delete_coffee" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                                No coffee menu available in this store.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div style="margin-top: 30px;">
                <a href="manage_store.php" style="
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #c59940da; 
                    color: white; 
                    text-decoration: none; 
                    border-radius: 5px; 
                    font-weight: bold;
                    font-size: 14px;
                ">← Back to Stores</a>
            </div>

        </div> 
    </div> 
<?php include 'footer.php'; ?>
</body>
</html>