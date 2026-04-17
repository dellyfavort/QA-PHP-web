<?php
include "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = strtolower(trim($_POST["username"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Generate email otomatis
    $email = $username . "@upitra.ac.id";

    // =========================
    // VALIDASI PASSWORD KUAT
    // =========================
    if (strlen($password) < 8) {
        $error = "Password minimal 8 karakter";
    }
    elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Harus ada huruf besar";
    }
    elseif (!preg_match("/[a-z]/", $password)) {
        $error = "Harus ada huruf kecil";
    }
    elseif (!preg_match("/[0-9]/", $password)) {
        $error = "Harus ada angka";
    }
    elseif (!preg_match("/[\W]/", $password)) {
        $error = "Harus ada simbol";
    }
    // =========================
    // VALIDASI KONFIRMASI PASSWORD
    // =========================
    elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    }

    // =========================
    // CEK USER SUDAH ADA
    // =========================
    if ($error == "") {
        $cek = mysqli_query($conn, "SELECT * FROM userlogin WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        }
    }

    // =========================
    // SIMPAN KE DATABASE
    // =========================
    if ($error == "") {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO userlogin (username, email, password)
                  VALUES ('$username', '$email', '$hashPassword')";

        if (mysqli_query($conn, $query)) {
            $success = "Pendaftaran berhasil! Email kamu: $email";
        } else {
            $error = "Gagal menyimpan data!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Member</title>
    
    <!-- Font Awesome untuk Icon Mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="style.css">
    
    <!-- CSS untuk Password Toggle -->
    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 0;
        }
        
        .password-wrapper input {
            width: 100%;
            padding: 14px 45px 14px 16px !important;
            margin-bottom: 0;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #5A6C7D;
            font-size: 16px;
            padding: 5px;
            transition: all 0.2s ease;
            z-index: 1;
        }
        
        .toggle-password:hover {
            color: var(--primary-blue);
        }
        
        .toggle-password:focus {
            outline: none;
            color: var(--dark-blue);
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Daftar Member</h2>

    <form method="POST" id="registerForm">

        <!-- Username -->
        <input type="text" name="username"
               placeholder="Username / Nama" required
               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">

        <!-- Password dengan Toggle -->
        <div class="password-wrapper">
            <input type="password" name="password" id="password"
                   placeholder="Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <!-- Konfirmasi Password dengan Toggle -->
        <div class="password-wrapper">
            <input type="password" name="confirm_password" id="confirm_password"
                   placeholder="Konfirmasi Password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('confirm_password', this)" aria-label="Toggle confirm password visibility">
                <i class="fas fa-eye"></i>
            </button>
        </div>

        <small>
            Minimal 8 karakter, huruf besar, kecil, angka, simbol
        </small>

        <button type="submit">Daftar</button>

    </form>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if (!empty($success)): ?>
    <div class="success">
        <?php echo htmlspecialchars($success); ?>
    </div>
    <?php endif; ?>

    <br>
    <a href="login.php">Sudah punya akun? Login</a>
    <br><br>
    <p>
        <a href="reset_password.php">Lupa Password?</a>
    </p>

</div>

<!-- JavaScript untuk Toggle Password -->
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        const isPassword = input.type === 'password';
        
        // Toggle input type
        input.type = isPassword ? 'text' : 'password';
        
        // Toggle icon (fa-eye <-> fa-eye-slash)
        if (isPassword) {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // Validasi real-time konfirmasi password
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirm = this.value;
        
        if (confirm && password !== confirm) {
            this.style.borderColor = '#DC2626';
            this.style.boxShadow = '0 0 0 4px rgba(220, 38, 38, 0.1)';
        } else {
            this.style.borderColor = '';
            this.style.boxShadow = '';
        }
    });
    
    // Reset validasi saat password berubah
    document.getElementById('password').addEventListener('input', function() {
        const confirmInput = document.getElementById('confirm_password');
        if (confirmInput.value) {
            const password = this.value;
            const confirm = confirmInput.value;
            
            if (password !== confirm) {
                confirmInput.style.borderColor = '#DC2626';
            } else {
                confirmInput.style.borderColor = '';
            }
        }
    });
</script>

</body>
</html>