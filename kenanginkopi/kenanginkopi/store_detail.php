<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$storeID = $_GET['id'];

$storeQuery = "SELECT * FROM Store WHERE StoreID = '$storeID'";
$storeResult = mysqli_query($conn, $storeQuery);
$storeData = mysqli_fetch_assoc($storeResult);

$menuQuery = "SELECT c.CoffeeID, c.CoffeeName, c.CoffeeDesc, sc.Price 
              FROM StoreCoffee sc 
              JOIN Coffee c ON sc.CoffeeID = c.CoffeeID 
              WHERE sc.StoreID = '$storeID'";
$menuResult = mysqli_query($conn, $menuQuery);

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest';

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'User') {
        header("Location: login.php");
        exit();
    }

    $coffeeID = $_POST['coffee_id'];
    $coffeeName = $_POST['coffee_name'];
    $coffeePrice = $_POST['coffee_price'];
    $coffeeDesc = $_POST['coffee_desc'];
    $qty = $_POST['qty'];
    $storeID_from_post = $_POST['store_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
        $_SESSION['cart_store_id'] = $storeID_from_post;
    }

    if ($_SESSION['cart_store_id'] != $storeID_from_post) {
        $_SESSION['cart'] = [];
        $_SESSION['cart_store_id'] = $storeID_from_post;
    }

    if (isset($_SESSION['cart'][$coffeeID])) {
        $_SESSION['cart'][$coffeeID]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$coffeeID] = [
            'id' => $coffeeID,
            'name' => $coffeeName,
            'price' => $coffeePrice,
            'desc' => $coffeeDesc,
            'qty' => $qty
        ];
    }
    echo "<script>alert('Coffee added to cart!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $storeData['StoreName']; ?> - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box">
            
            <div style="border-bottom: 1px solid #eee; margin-bottom: 20px; padding-bottom: 10px;">
                <h1 style="margin: 0; color: #5c4033;"><?php echo $storeData['StoreName']; ?></h1>
                <p class="subtitle" style="text-align: left; margin: 5px 0;">
                    📍 Location: <?php echo $storeData['StoreLocation']; ?>
                </p>
                <a href="index.php" style="color: #666; font-size: 14px; text-decoration: none;">← Back to Home</a>
            </div>
            
            <h3 style="color: #5c4033; margin-bottom: 20px;">Menu Available</h3>
            
            <div class="store-list">
                <?php if (mysqli_num_rows($menuResult) > 0): ?>
                    <?php while($menu = mysqli_fetch_assoc($menuResult)): ?>
                        
                        <div class="store-card" style="display: block;"> <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <h3 style="margin: 0; font-size: 18px; color: #333;"><?php echo $menu['CoffeeName']; ?></h3>
                                <span style="font-weight: bold; color: #c49a6c;">Rp <?php echo number_format($menu['Price'], 0, ',', '.'); ?></span>
                            </div>
                            
                            <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                                <?php echo $menu['CoffeeDesc']; ?>
                            </p>

                            <?php if ($role == 'User'): ?>
                                <form method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    <input type="hidden" name="coffee_id" value="<?php echo $menu['CoffeeID']; ?>">
                                    <input type="hidden" name="coffee_name" value="<?php echo $menu['CoffeeName']; ?>">
                                    <input type="hidden" name="coffee_desc" value="<?php echo $menu['CoffeeDesc']; ?>">
                                    <input type="hidden" name="coffee_price" value="<?php echo $menu['Price']; ?>">
                                    <input type="hidden" name="store_id" value="<?php echo $storeID; ?>">
                                    
                                    <input type="number" name="qty" value="1" min="1" 
                                           style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                                    <button type="submit" name="add_to_cart" class="btn-small">Add to Cart</button>
                                </form>
                            <?php endif; ?>
                            
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #888;">No coffee menu available yet.</p>
                <?php endif; ?>
            </div>

        </div> 
    </div> 
<?php include 'footer.php'; ?>
</body>
</html>