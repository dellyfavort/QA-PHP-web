<?php
session_start();
include "db.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION["email"];

$query = "SELECT * FROM userlogin WHERE email='$email'";
$result = mysqli_query($conn,$query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Membership Ebook</title>
    
    <!-- HUBUNGKAN KE CSS EKSTERNAL -->
    <link rel="stylesheet" href="style.css">
    
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="nav-left">
            <a href="home.php" class="home-link">Membership E-Book Library</a>
        </div>

        <div class="nav-right">
            <a href="profile.php" class="username-link">
                <?php echo $user["username"]; ?>
            </a>

            <span class="divider">|</span>

            <a href="logout.php" class="logout-link">
                Logout
            </a>
        </div>
    </div>

    <!-- HERO BANNER -->
    <div class="hero">
        <h1>LOTS OF E-BOOKS</h1>
        <p>Welcome to your digital ebook membership</p>
    </div>

    <!-- WELCOME USER -->
    <div class="welcome">
        Welcome, <b><?php echo $user["username"]; ?></b> 
    </div>

    <!-- CATEGORY -->
    <div class="category">
        <div class="card">Teknologi</div>
        <div class="card">Psikologi</div>
        <div class="card">Bisnis</div>
        <div class="card">Sains</div>
        <div class="card">Sejarah</div>
    </div>

    <h2>Daftar Buku</h2>

    <div class="book-list">
        <div class="book">
            <img src="books/book1.jpg" class="cover">
            <p>Artificial Intelligence Basics</p>
            <a href="books/book1.pdf">Baca</a>
        </div>

        <div class="book">
            <img src="books/book2.jpg" class="cover">
            <p>Machine Learning</p>
            <a href="books/book2.pdf">Baca</a>
        </div>

        <div class="book">
            <img src="books/book3.jpg" class="cover">
            <p>Deep Learning</p>
            <a href="books/book3.pdf">Baca</a>
        </div>
    </div>

</body>
</html>