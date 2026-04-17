<?php
$requireDb = require_once __DIR__ . '/config/config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = trim($_POST['name'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$password = trim($_POST['password'] ?? '');

	if ($name === '' || $email === '' || $password === '') {
		$message = 'Please fill in all fields.';
	} else {
		$checkUser = $pdo->prepare('SELECT UserId FROM Users WHERE Email = :email LIMIT 1');
		$checkUser->execute([':email' => $email]);

		if ($checkUser->fetch()) {
			$message = 'Email already exists.';
		} else {
			$roleStmt = $pdo->prepare("SELECT RoleId FROM Roles WHERE RoleName = 'Member' LIMIT 1");
			$roleStmt->execute();
			$roleId = $roleStmt->fetchColumn();

			if (!$roleId) {
				$createRole = $pdo->prepare("INSERT INTO Roles (RoleId, RoleName) VALUES (UUID(), 'Member')");
				$createRole->execute();

				$roleStmt->execute();
				$roleId = $roleStmt->fetchColumn();
			}

			$passwordHash = password_hash($password, PASSWORD_DEFAULT);
			$insertUser = $pdo->prepare(
				'INSERT INTO Users (UserId, RoleId, Email, PasswordHash, IsActive, CreatedDate) VALUES (UUID(), :role_id, :email, :password_hash, 1, NOW())'
			);
			$insertUser->execute([
				':role_id' => $roleId,
				':email' => $email,
				':password_hash' => $passwordHash,
			]);
			$message = 'sucessfully';
		}
	}
}

echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

if ($message === 'sucessfully') {
	echo ' <a href="login.html">Go to login</a>';
}
?>

