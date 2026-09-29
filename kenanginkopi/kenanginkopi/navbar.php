<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

date_default_timezone_set('Asia/Jakarta'); 
$currentDate = date('l, d F Y');
?>

<nav class="navbar">
    <div class="nav-left">
        <a href="index.php" class="logo">KenanginKopi</a>
    </div>

    <div class="nav-center">
        <span><?php echo $currentDate; ?></span>
    </div>

    <div class="nav-right">
        
        <?php if ($role == 'Admin'): ?>
            <div class="dropdown">
                <button class="dropbtn">Manage ▾</button>
                <div class="dropdown-content">
                    <a href="manage_user.php">Manage User</a>
                    <a href="manage_store.php">Manage Store</a>
                </div>
            </div>
            <span class="user-name"><?php echo $username; ?></span>
            <a href="logout.php" class="btn-logout">Logout</a>

        <?php elseif ($role == 'User'): ?>
            <a href="cart.php" class="btn-login" style="margin-right: 15px;">Cart 🛒</a>
            
            <a href="profile.php" class="user-name-link"><?php echo $username; ?></a>
            <a href="logout.php" class="btn-logout">Logout</a>

        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
        <?php endif; ?>
        
    </div>

</nav>