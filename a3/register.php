<?php
require_once 'includes/db_connect.inc';
require_once 'includes/functions.inc';

$page_title = 'Register';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);

    $sql = "INSERT INTO users (username, email, password, phone, location)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $username, $email, $password, $phone, $location);

    try {
        mysqli_stmt_execute($stmt);

        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['username'] = $username;

        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error = "Could not register. Username or email may already exist.";
    }
}

include 'includes/header.inc';
?>

<h1 class="page-title text-center">Register for PetConnect</h1>

<div class="auth-card">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label class="form-label">Username</label>
        <input class="form-control mb-3" name="username" required>

        <label class="form-label">Email</label>
        <input class="form-control mb-3" type="email" name="email" required>

        <label class="form-label">Password</label>
        <input class="form-control mb-3" type="password" name="password" required>

        <label class="form-label">Phone Optional</label>
        <input class="form-control mb-3" name="phone">

        <label class="form-label">Location Optional</label>
        <input class="form-control mb-3" name="location" placeholder="e.g., Melbourne, VIC">

        <button class="btn btn-primary w-100" type="submit">Sign Up</button>
    </form>

    <p class="text-center mt-4 small">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

<?php include 'includes/footer.inc'; ?>