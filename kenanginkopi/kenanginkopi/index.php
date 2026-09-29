<?php
include 'connection.php';
$query = "SELECT * FROM Store";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - KenanginKopi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        
        <div class="content-box">
            
            <div style="border-bottom: 1px solid #eee; margin-bottom: 20px; padding-bottom: 10px;">
                <h1>KenanginKopi</h1>
                <p class="subtitle">Favourable taste for your mood</p>
            </div>

            <div class="store-list">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        
                        <div class="store-card">
                            <h3><?php echo $row['StoreName']; ?></h3>
                            
                            <a href="store_detail.php?id=<?php echo $row['StoreID']; ?>" class="btn-detail">View Details</a>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center; color:#888;">No stores available currently.</p>
                <?php endif; ?>
            </div>

        </div> 
    </div>  
<?php include 'footer.php'; ?>
</body>
</html>