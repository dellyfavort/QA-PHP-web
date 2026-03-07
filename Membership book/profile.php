<?php
session_start();
include "db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION["email"];

// ambil data user
$queryUser = "SELECT * FROM userlogin WHERE email='$email'";
$resultUser = mysqli_query($conn, $queryUser);
$user = mysqli_fetch_assoc($resultUser);

$user_id = $user["id"];

$queryKomentar = "SELECT * FROM komentar WHERE user_id='$user_id' ORDER BY tanggal DESC";
$resultKomentar = mysqli_query($conn, $queryKomentar);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile User</title>
    
    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="style.css">
    <!-- Jika style.css di root, pakai: href="style.css" -->
    
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="nav-left">
            <!-- Title bisa diklik ke home -->
            <a href="home.php" class="navbar-brand">Membership E-Book Library</a>
        </div>

        <div class="nav-right">
            <a href="profile.php" class="username-link">
                <?php echo $user["username"]; ?>
            </a>
            <span class="divider">|</span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </div>

    <!-- CONTAINER PROFILE -->
    <div class="profile-container">
        <h2>Profil Member</h2>

        <!-- ✅ PROFILE INFO (Dibungkus div) -->
        <div class="profile-info">
            <p><b>Username :</b> <?php echo htmlspecialchars($user["username"]); ?></p>
            <p><b>Email :</b> <?php echo htmlspecialchars($user["email"]); ?></p>
        </div>

        <hr>

        <h3>Komentar Saya</h3>

        <?php if (mysqli_num_rows($resultKomentar) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($resultKomentar)): ?>
                <div class="comment">
                    <?php echo htmlspecialchars($row["komentar"]); ?>
                    <br><small><?php echo htmlspecialchars($row["tanggal"]); ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- ✅ Tanpa background box -->
            <p class="no-comment">Belum ada komentar</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="home.php" class="back-link">Kembali ke Home</a>
        </div>
    </div>

</body>
</html>