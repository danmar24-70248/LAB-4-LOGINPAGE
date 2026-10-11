<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION['role'] != "admin") {
    header("Location: " . ($_SESSION['role'] == "student" ? "home2.php" : "index.php"));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin Dashboard</span>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Log out</a>
        </div>
    </div>
</nav>


<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
            <p class="card-text">This is your Admin dashboard.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>