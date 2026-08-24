<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            $error = 'Please fill in every field.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } else {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');
            $stmt->execute([$username, $email]);

            if ($stmt->fetch()) {
                $error = 'That username or email is already registered.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, "user")');
                $stmt->execute([$username, $email, $hash]);
                $success = true;
            }
        }
    }
}

$pageTitle  = 'Register';
$activePage = 'register';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">Account</span>
    <h1>Create an Account</h1>
    <p>Join RS8 to track orders and save your build.</p>
</section>

<section>
    <div class="container">
        <div class="auth-card">
            <?php if ($success): ?>
                <p class="form-message form-success">Account created — you can now <a href="login.php">log in</a>.</p>
            <?php else: ?>
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
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" autocomplete="email" required>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" autocomplete="new-password" minlength="6" required>
                    </div>

                    <div class="field">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" minlength="6" required>
                    </div>

                    <button type="submit" class="btn">Create Account</button>
                </form>

                <p class="auth-alt">Already have an account? <a href="login.php">Log in</a></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
