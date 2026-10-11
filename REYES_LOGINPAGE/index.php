<?php
session_start();
require 'db.php';

// Already logged in? Send them to the right page
if (isset($_SESSION["username"]) && !empty($_SESSION["role"])) {
    if ($_SESSION["role"] == "admin") {
        header("Location: home.php");
        exit;
    } elseif ($_SESSION["role"] == "student") {
        header("Location: home2.php");
        exit;
    }
}

$error = "";

if (isset($_POST["sub"])) {
    $uname = trim($_POST["username"]);
    $pw    = $_POST["pass"];

    // Prepared statement: protects against SQL injection
    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($pw, $row["password"])) {
        session_regenerate_id(true);  
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"]     = $row["role"];

        header("Location: " . ($row["role"] == "admin" ? "home.php" : "home2.php"));
        exit;
    } else {
        $error = "Wrong username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">

            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Login</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="sub" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>