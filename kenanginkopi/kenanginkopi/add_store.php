<?php
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') { 
    header("Location: login.php"); 
    exit(); 
}

$error = "";
if (isset($_POST['add_store'])) {
    $name = $_POST['store_name'];
    $location = $_POST['location'];

    if (str_word_count($name) < 2) {
        $error = "Store Name must be at least 2 words.";
    } elseif (empty($location)) {
        $error = "Please choose a location.";
    } else {
        $newID = "S" . rand(100, 999);
        $query = "INSERT INTO Store VALUES ('$newID', '$name', '$location')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Store added successfully!'); window.location='manage_store.php';</script>";
            exit();
        } else {
            $error = "Failed to add store: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Add Store - KenanginKopi</title> 
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="auth-wrapper">
        
        <div class="auth-box">
            <h2>Add New Store</h2>
            
            <?php if($error != ""): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>Store Name</label>
                <input type="text" name="store_name" class="input-field" placeholder="e.g. Morning Night Store">

                <label>Store Location</label>
                <select name="location" class="input-field" style="background-color: white;">
                    <option value="">-- Choose Location --</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                    <option value="Bali">Bali</option>
                    <option value="Medan">Medan</option>
                </select>

                <button type="submit" name="add_store" class="btn-login" style="margin-top: 10px;">Add Store</button>
            </form>
            
            <br>
            <a href="manage_store.php" style="text-decoration: none; color: #666; font-size: 14px;">← Back to Manage Store</a>
        </div>

    </div>
<?php include 'footer.php'; ?>
</body>
</html>