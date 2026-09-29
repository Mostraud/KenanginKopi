<?php
include 'connection.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$userID = $_SESSION['user_id'];

$transQuery = "SELECT t.*, s.StoreName, s.StoreLocation 
               FROM Transactions t 
               JOIN Store s ON t.StoreID = s.StoreID 
               WHERE t.UserID = '$userID' 
               ORDER BY t.TransactionDate DESC";
$transResult = mysqli_query($conn, $transQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Order History - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box">
            
            <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
                <h2 style="margin: 0; color: #5c4033;">Order History</h2>
                <p style="margin: 5px 0 0 0; color: #888;">List of your past coffee orders</p>
            </div>

            <?php if (mysqli_num_rows($transResult) == 0): ?>
                
                <div style="text-align: center; padding: 40px;">
                    <p style="color: #888; font-size: 18px;">You haven't ordered anything yet.</p>
                    <a href="index.php" class="btn-login" style="margin-top: 10px;">Order Now</a>
                </div>

            <?php else: ?>
                
                <?php while($trans = mysqli_fetch_assoc($transResult)): ?>
                    
                    <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 25px; background-color: #fafafa;">
                        
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <div>
                                <span style="font-weight: bold; color: #5c4033; font-size: 18px;">
                                    #<?php echo $trans['TransactionID']; ?>
                                </span>
                                <div style="color: #666; font-size: 14px; margin-top: 5px;">
                                    📅 <?php echo date('d F Y', strtotime($trans['TransactionDate'])); ?>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span style="background-color: #e6dcc5; color: #5c4033; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">
                                    Done
                                </span>
                                <div style="font-weight: bold; margin-top: 5px; color: #333;">
                                    📍 <?php echo $trans['StoreName']; ?>
                                </div>
                                <div style="font-size: 12px; color: #666;">
                                    (<?php echo $trans['StoreLocation']; ?>)
                                </div>
                            </div>
                        </div>

                        <table class="table-cart" style="margin-bottom: 15px;">
                            <thead>
                                <tr>
                                    <th>Coffee</th>
                                    <th>Qty</th>
                                    <th style="text-align: right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tid = $trans['TransactionID'];
                                    $detailQuery = "SELECT td.*, c.CoffeeName 
                                                    FROM TransactionDetails td 
                                                    JOIN Coffee c ON td.CoffeeID = c.CoffeeID 
                                                    WHERE td.TransactionID = '$tid'";
                                    $details = mysqli_query($conn, $detailQuery);
                                    
                                    while($item = mysqli_fetch_assoc($details)):
                                ?>
                                <tr style="background-color: white;"> <td><?php echo $item['CoffeeName']; ?></td>
                                    <td style="text-align: center;"><?php echo $item['Qty']; ?></td>
                                    <td style="text-align: right;">Rp <?php echo number_format($item['Subtotal']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        
                        <div style="text-align: right; border-top: 1px solid #eee; padding-top: 15px;">
                            <span style="font-size: 14px; color: #666; margin-right: 10px;">Total Amount:</span>
                            <span style="font-size: 20px; font-weight: bold; color: #28a745;">
                                Rp <?php echo number_format($trans['TotalPrice']); ?>
                            </span>
                        </div>

                    </div> <?php endwhile; ?>

            <?php endif; ?>

            <div style="margin-top: 20px;">
                <a href="profile.php" style="text-decoration: none; color: #666;">← Back to Profile</a>
            </div>

        </div> 
    </div> 
<?php include 'footer.php'; ?>
</body>
</html>