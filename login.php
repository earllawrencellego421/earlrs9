<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

// Already logged in? Send them where they belong.
if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? 'admin/dashboard.php' : 'dashboard.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Please enter both your username and password.';
        } else {
            $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = ? LIMIT 1');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                header('Location: ' . ($user['role'] === 'admin' ? 'admin/dashboard.php' : 'dashboard.php'));
                exit;
            }

            $error = 'Invalid username or password.';
        }
    }
}

$pageTitle  = 'Login';
$activePage = 'login';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">Account</span>
    <h1>Log In</h1>
    <p>Access your RS8 account, or the admin dashboard.</p>
</section>

<section>
    <div class="container">
        <div class="auth-card">
            <?php if ($error): ?>
                <p class="form-message form-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken()) ?>">

                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" autocomplete="username" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn">Log In</button>
            </form>

            <p class="auth-alt">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
