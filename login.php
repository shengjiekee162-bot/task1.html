<?php
session_start();
require_once __DIR__ . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($email === '' || $password === '') {
    header('Location: login.html?error=1');
    exit;
}

 $stmt = $pdo->prepare(
    'SELECT u.UserId, u.Email, u.PasswordHash, r.RoleName
     FROM Users u
     LEFT JOIN Roles r ON u.RoleId = r.RoleId
     WHERE u.Email = :email
     LIMIT 1'
);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['PasswordHash'])) {
    header('Location: login.html?error=1');
    exit;
}

$_SESSION['user_id'] = $user['UserId'];
$_SESSION['user_email'] = $user['Email'];
$_SESSION['role'] = $user['RoleName'] ?? 'Member';
header('Location: index.php');
exit;