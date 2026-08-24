# RS8 Racing — PHP + MySQL Backend

## What's in here
```
rs8-website/
├── index.php, about.php, contact.php   ← your pages, now PHP
├── login.php, register.php, logout.php ← account system
├── dashboard.php                       ← logged-in user's account page
├── admin/dashboard.php                 ← admin-only panel (users + contact messages)
├── config/db.php                       ← database connection settings
├── includes/                           ← auth.php, header.php, footer.php (shared on every page)
├── database/rs8.sql                 ← run this once to create your database
├── css/style.css
├── js/main.js
└── images/
```

## Setup (local — XAMPP / MAMP / Laragon)
1. Copy this whole folder into your server's web root (e.g. `htdocs/rs8-website`).
2. Open phpMyAdmin, click **Import**, and import `database/rs8.sql`. This creates the `rs8_racing` database, the `users` and `contact_messages` tables, and seeds the admin account.
3. Open `config/db.php` and check `DB_HOST` / `DB_USER` / `DB_PASS` match your local MySQL setup (XAMPP defaults are usually `root` with no password — that's already set).
4. Visit `http://localhost/rs8-website/index.php` in your browser.

## Setup (real hosting / cPanel)
1. In cPanel, use **MySQL Databases** to create a database and a database user, and give that user full privileges on the database.
2. Open **phpMyAdmin**, select your new database, click **Import**, and upload `database/rs8.sql`. (If cPanel already forced a prefix on your database/user name, edit the `USE rs8_racing;` line and the `CREATE DATABASE` line in `rs8.sql` to match before importing.)
3. Edit `config/db.php` with the real database name, username, and password cPanel gave you.
4. Upload every file in this folder to your `public_html` (or a subfolder) via FTP or the File Manager.

## Logging in
- **Admin** — username `earl`, password `earl123`, at `login.php`. You'll land on `admin/dashboard.php`, which lists every registered user and every contact form submission.
- **Customers** — anyone can create an account at `register.php` and log in at `login.php`; they land on `dashboard.php`.

## Please do this before going live
1. **Change the admin password.** `earl123` is fine for testing, not for production. Easiest way: log in, then run this once in phpMyAdmin's SQL tab with a password of your choice:
   ```sql
   UPDATE users SET password_hash = '<paste a new hash here>' WHERE username = 'earl';
   ```
   Generate that hash by running `php -r "echo password_hash('YOUR-NEW-PASSWORD', PASSWORD_DEFAULT);"` from a terminal, or ask me and I'll generate one for you.
2. **Serve the site over HTTPS.** Login and registration send passwords in the request body — without HTTPS those are readable in transit.
3. **Don't commit `config/db.php` with real credentials to a public GitHub repo.** If you're using version control, add it to `.gitignore` and keep a `config/db.example.php` template instead.

## How the security pieces work
- Passwords are never stored or compared as plain text — `password_hash()` / `password_verify()` (bcrypt) handle that.
- Every database query uses PDO prepared statements, so form input can't be used to manipulate SQL.
- Every form includes a CSRF token tied to the session, checked before anything is saved.
- All output (`htmlspecialchars()`) is escaped before it's echoed back into HTML, to prevent stored/reflected XSS from usernames, messages, etc.
- `admin/dashboard.php` calls `requireAdmin()` before it queries or renders anything — a logged-in customer who guesses the URL gets redirected straight back to `login.php`.
