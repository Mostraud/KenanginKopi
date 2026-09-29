<?php
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'User') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_cart'])) {
    $id = $_POST['coffee_id'];
    $new_qty = $_POST['qty'];
    if ($new_qty > 0) {
        $_SESSION['cart'][$id]['qty'] = $new_qty;
    }
}

if (isset($_POST['delete_item'])) {
    $id = $_POST['coffee_id'];
    unset($_SESSION['cart'][$id]);
}

$success_msg = "";
if (isset($_POST['pay']) && !empty($_SESSION['cart'])) {
    $userID = $_SESSION['user_id'];
    $storeID = $_SESSION['cart_store_id'];
    $date = date('Y-m-d');
    
    $grandTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += ($item['price'] * $item['qty']);
    }

    $transID = "T" . rand(1000, 9999);
    $queryTrans = "INSERT INTO Transactions (TransactionID, UserID, StoreID, TransactionDate, TotalPrice) 
                   VALUES ('$transID', '$userID', '$storeID', '$date', '$grandTotal')";
    
    if (mysqli_query($conn, $queryTrans)) {
        foreach ($_SESSION['cart'] as $coffeeID => $item) {
            $qty = $item['qty'];
            $subtotal = $item['price'] * $qty;
            mysqli_query($conn, "INSERT INTO TransactionDetails VALUES ('$transID', '$coffeeID', '$qty', '$subtotal')");
        }
        unset($_SESSION['cart']);
        unset($_SESSION['cart_store_id']);
        $success_msg = "Payment Successful! Your Transaction ID: <b>" . $transID . "</b>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Cart - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        <div class="content-box">
            
            <h2 style="color: #5c4033; margin-top: 0; margin-bottom: 25px;">Shopping Cart</h2>
            
            <?php if ($success_msg): ?>
                <div class="alert-success" style="text-align: center;"><?php echo $success_msg; ?></div>
            <?php endif; ?>

            <?php if (empty($_SESSION['cart'])): ?>
                
                <div style="text-align: center; padding: 50px 20px;">
                    <p style="font-size: 18px; color: #888;">Your cart is currently empty</p>
                    <a href="index.php" class="btn-login" style="margin-top: 10px;">Browse Menu</a>
                </div>

            <?php else: ?>
                
                <table class="table-cart">
                    <thead>
                        <tr>
                            <th>Coffee</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th style="text-align: center;">Qty</th>
                            <th>Subtotal</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grandTotal = 0;
                        foreach ($_SESSION['cart'] as $id => $item): 
                            $subtotal = $item['price'] * $item['qty'];
                            $grandTotal += $subtotal;
                        ?>
                        <tr>
                            <td style="font-weight: bold; color: #333;"><?php echo $item['name']; ?></td>
                            <td style="color: #777; font-size: 14px;"><?php echo $item['desc']; ?></td>
                            <td>Rp <?php echo number_format($item['price']); ?></td>
                            
                            <td style="text-align: center;">
                                <form method="POST" style="display:flex; justify-content:center; align-items:center; gap:5px;">
                                    <input type="hidden" name="coffee_id" value="<?php echo $id; ?>">
                                    <input type="number" name="qty" value="<?php echo $item['qty']; ?>" min="1" class="qty-input">
                                    <button type="submit" name="update_cart" style="background:none; border:none; color:#c49a6c; cursor:pointer; font-weight:bold; font-size:12px;">↻</button>
                                </form>
                            </td>
                            
                            <td style="font-weight: bold; color: #5c4033;">Rp <?php echo number_format($subtotal); ?></td>
                            
                            <td style="text-align: center;">
                                <form method="POST">
                                    <input type="hidden" name="coffee_id" value="<?php echo $id; ?>">
                                    <button type="submit" name="delete_item" class="btn-delete" style="font-size: 12px;">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <span class="total-price-label">Total Amount</span>
                    <span class="total-price-value">Rp <?php echo number_format($grandTotal); ?></span>
                    
                    <form method="POST">
                        <button type="submit" name="pay" class="btn-pay-smooth">Pay Now</button>
                    </form>
                </div>

            <?php endif; ?>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>