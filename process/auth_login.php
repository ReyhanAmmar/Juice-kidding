<?php
session_start();
require_once '../config/koneksi.php';

// Tolak akses langsung bukan dari POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi kosong
if (empty($email) || empty($password)) {
    header("Location: ../login.php?error=empty");
    exit;
}

// Cari user berdasarkan email
$email_esc = mysqli_real_escape_string($koneksi, $email);
$query     = "SELECT id_user, nama_lengkap, password, id_role
              FROM users WHERE email = '$email_esc' LIMIT 1";
$result    = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 0) {
    header("Location: ../login.php?error=wrong");
    exit;
}

$user = mysqli_fetch_assoc($result);

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    header("Location: ../login.php?error=wrong");
    exit;
}

// Simpan ke session
$_SESSION['id_user']      = $user['id_user'];
$_SESSION['nama_lengkap'] = $user['nama_lengkap'];
$_SESSION['id_role']      = $user['id_role'];

// Redirect sesuai role
switch ($user['id_role']) {
    case 2: header("Location: ../pages/admin/dashboard.php");        break;
    case 3: header("Location: ../pages/mitra/dashboard_kasir.php");  break;
    case 4: header("Location: ../pages/mitra/dashboard_driver.php"); break;
    default: header("Location: ../pages/customer/index.php");        break;
}
exit;