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
$error = "";

if (isset($_POST['add_coffee'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];

    if (!ctype_alpha(str_replace(' ', '', $name))) { 
        $error = "Coffee Name must be alphabetic only.";
    } elseif ($price < 10000 || $price > 100000) {
        $error = "Price must be between 10,000 and 100,000.";
    } elseif (str_word_count($desc) < 3) {
        $error = "Description must be at least 3 words.";
    } else {
        $coffeeID = "C" . rand(1000, 9999);

        $q1 = "INSERT INTO Coffee VALUES ('$coffeeID', '$name', '$desc')";

        $q2 = "INSERT INTO StoreCoffee VALUES ('$storeID', '$coffeeID', '$price')";

        if (mysqli_query($conn, $q1) && mysqli_query($conn, $q2)) {
            echo "<script>alert('Coffee added successfully!'); window.location='manage_coffee.php?store_id=$storeID';</script>";
            exit();
        } else {
            $error = "Failed to add coffee: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Add Coffee - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="auth-wrapper">
        
        <div class="auth-box">
            <h2>Add Coffee</h2>
            <p style="color: #666; margin-top: -10px; margin-bottom: 20px;">
                to Store ID: <b><?php echo $storeID; ?></b>
            </p>
            
            <?php if($error != ""): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>Coffee Name</label>
                <input type="text" name="name" class="input-field" placeholder="e.g. Hazelnut Latte">

                <label>Price (Rp)</label>
                <input type="number" name="price" class="input-field" placeholder="10000 - 100000">

                <label>Description</label>
                <textarea name="desc" class="input-field" rows="3" placeholder="Describe the coffee..."></textarea>

                <button type="submit" name="add_coffee" class="btn-login" style="margin-top: 10px;">Add Coffee</button>
            </form>
            
            <br>
            <a href="manage_coffee.php?store_id=<?php echo $storeID; ?>" style="text-decoration: none; color: #666; font-size: 14px;">← Back to Manage Coffee</a>
        </div>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>