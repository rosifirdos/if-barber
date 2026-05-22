<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded credentials as requested for prototype
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>IF Barber | Admin Login</title>
    
    <!-- 1. Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- 2. Tailwind Configuration -->
    <script src="js/tailwind.config.js"></script>

    <!-- 3. Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- 4. Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-background text-on-surface antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
    
    <!-- Global Background Atmosphere -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-surface-container-low via-background to-background pointer-events-none -z-10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-primary/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md px-margin-mobile">
        <!-- Brand / Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-container rounded-xl flex items-center justify-center text-on-primary font-headline-xl text-3xl font-bold shadow-[0_0_20px_rgba(212,175,55,0.3)] mx-auto mb-4">
                IF
            </div>
            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">Admin Portal</h1>
            <p class="font-body-md text-body-md text-muted-gray mt-2">Masuk untuk mengelola IF Barber</p>
        </div>

        <!-- Login Form Panel -->
        <div class="glass-panel p-8 rounded-2xl border border-white/10 glow-accent relative z-10">
            
            <?php if ($error): ?>
                <div class="bg-error/10 border border-error/30 text-error px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="flex flex-col gap-5">
                <div class="flex flex-col gap-2">
                    <label for="username" class="font-label-md text-xs text-on-surface-variant uppercase tracking-wider">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-gray text-[20px]">person</span>
                        <input type="text" id="username" name="username" required autocomplete="username" placeholder="admin"
                               class="w-full bg-surface-container-lowest border border-white/10 rounded-xl pl-12 pr-4 py-3 text-on-surface placeholder:text-muted-gray/50 focus:outline-none focus:border-primary/50 transition-colors">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="font-label-md text-xs text-on-surface-variant uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-gray text-[20px]">lock</span>
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                               class="w-full bg-surface-container-lowest border border-white/10 rounded-xl pl-12 pr-4 py-3 text-on-surface placeholder:text-muted-gray/50 focus:outline-none focus:border-primary/50 transition-colors">
                    </div>
                </div>

                <button type="submit" class="mt-4 w-full bg-primary-container text-on-primary font-bold text-label-md py-3.5 rounded-xl hover:bg-gold-hover transition-colors active:scale-95 cursor-pointer shadow-[0_0_15px_rgba(212,175,55,0.2)]">
                    Sign In
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <a href="index.html" class="text-muted-gray hover:text-primary transition-colors text-sm font-label-md flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
