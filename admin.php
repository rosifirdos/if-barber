<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>IF Barber - Admin Dashboard</title>
    
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
<body class="bg-background text-on-surface font-body-md min-h-screen flex selection:bg-primary/30 selection:text-primary">
    <!-- Sidebar Navigation -->
    <aside class="hidden md:flex flex-col w-64 bg-surface-container-lowest border-r border-white/5 h-screen sticky top-0 flex-shrink-0 z-40 relative overflow-hidden">
        <!-- Ambient Glow behind sidebar -->
        <div class="absolute top-0 left-0 w-full h-64 bg-primary/5 blur-[100px] pointer-events-none rounded-full -translate-y-1/2"></div>
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary font-headline-md text-headline-md font-bold shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                IF
            </div>
            <span class="font-headline-md text-headline-md text-primary tracking-tight font-bold">Barber Admin</span>
        </div>
        <nav class="flex-1 px-4 py-6 flex flex-col gap-2 relative z-10">
            <!-- Active State -->
            <a class="flex items-center gap-4 px-4 py-3 bg-surface/80 backdrop-blur-sm rounded-lg text-primary border border-white/10 shadow-[0_0_20px_rgba(212,175,55,0.05)] relative overflow-hidden group" href="#">
                <div class="absolute left-0 top-0 w-1 h-full bg-primary rounded-r-full shadow-[0_0_10px_rgba(212,175,55,0.8)]"></div>
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span class="font-label-md text-label-md uppercase tracking-wider">Dashboard</span>
            </a>
            <!-- Inactive States -->
            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-muted-gray hover:text-on-surface hover:bg-surface-container/50 transition-all duration-300" href="#">
                <span class="material-symbols-outlined" data-icon="event_note">event_note</span>
                <span class="font-label-md text-label-md uppercase tracking-wider">Bookings</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-muted-gray hover:text-on-surface hover:bg-surface-container/50 transition-all duration-300" href="#">
                <span class="material-symbols-outlined" data-icon="content_cut">content_cut</span>
                <span class="font-label-md text-label-md uppercase tracking-wider">Services</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-muted-gray hover:text-on-surface hover:bg-surface-container/50 transition-all duration-300" href="#">
                <span class="material-symbols-outlined" data-icon="bar_chart">bar_chart</span>
                <span class="font-label-md text-label-md uppercase tracking-wider">Reports</span>
            </a>
        </nav>
        <div class="p-6 border-t border-white/5 relative z-10">
            <div class="flex items-center gap-3">
                <img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover border border-white/10" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCb4GwqXtHqBCE06rAROWgk__2iA1C5x0Y_97L6zVUuTul-fskC7-c8cZLmXft5-Sbl5EqlBRP0pTZfzRL2Re9IUsJjkKLu-QumoyjjRjp8nNhR5hlJFpilZxkeSsV6eZ-oXblF-nvLa99aq4muLlJMuEu-22EpatiZf7WNH4hXp7_aMnz1PmWi1IuExiFCAIEQ5HkJSNezVn71Nj5Hwnz33PucQzt6d0EgIdzhsuzOBH0IYaAkqmL1cVkGiczTPbudmF4YcNkciX33"/>
                <div>
                    <p class="font-label-sm text-label-sm text-on-surface">Admin User</p>
                    <p class="font-label-sm text-label-sm text-muted-gray text-[10px]">System Manager</p>
                </div>
                <!-- Logout Button -->
                <a href="logout.php" class="ml-auto text-muted-gray hover:text-error transition-colors" title="Logout">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="flex-1 h-screen overflow-y-auto relative">
        <!-- Global Background Atmosphere -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-surface-container-low via-background to-background pointer-events-none -z-10"></div>
        <div class="max-w-container-max mx-auto p-margin-mobile md:p-margin-desktop flex flex-col gap-section-gap pt-8 md:pt-margin-desktop">
            
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <h1 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl text-on-surface mb-2">Overview</h1>
                    <p class="font-body-md text-body-md text-muted-gray">Monitor today's operations and metrics.</p>
                </div>
                <div class="flex gap-4 items-center">
                    <div class="px-4 py-2 bg-surface-container/40 backdrop-blur-md rounded-full border border-white/5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-sm" data-icon="calendar_today">calendar_today</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Today, Oct 24</span>
                    </div>
                </div>
            </header>

            <!-- Stats Grid -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <!-- Card 1 -->
                <div class="bg-surface/60 backdrop-blur-xl border border-white/10 rounded-xl p-6 relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/5 rounded-full blur-[30px] group-hover:bg-primary/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-label-md text-label-md text-muted-gray uppercase tracking-widest">Today's Queues</h3>
                        <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center border border-white/5">
                            <span class="material-symbols-outlined text-primary text-[18px]" data-icon="groups">groups</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface" id="statTodayQueue">24</span>
                        <span class="font-label-sm text-label-sm text-status-completed flex items-center">
                            <span class="material-symbols-outlined text-[14px]" data-icon="arrow_upward">arrow_upward</span> 12%
                        </span>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-surface/60 backdrop-blur-xl border border-white/10 rounded-xl p-6 relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-secondary/5 rounded-full blur-[30px] group-hover:bg-secondary/10 transition-all duration-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-label-md text-label-md text-muted-gray uppercase tracking-widest">Popular Service</h3>
                        <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center border border-white/5">
                            <span class="material-symbols-outlined text-secondary text-[18px]" data-icon="star">star</span>
                        </div>
                    </div>
                    <div class="flex flex-col justify-end h-full mt-2">
                        <span class="font-headline-md text-headline-md text-on-surface" id="statPopularService">Executive Fade</span>
                        <span class="font-label-sm text-label-sm text-muted-gray mt-1" id="statPopularCount">14 bookings today</span>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-surface/60 backdrop-blur-xl border border-white/10 rounded-xl p-6 relative overflow-hidden group">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary-container/10 rounded-full blur-[40px] group-hover:bg-primary-container/20 transition-all duration-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-label-md text-label-md text-muted-gray uppercase tracking-widest">Estimated Revenue</h3>
                        <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center border border-white/5">
                            <span class="material-symbols-outlined text-primary-container text-[18px]" data-icon="account_balance_wallet">account_balance_wallet</span>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="font-headline-md text-headline-md text-primary-container/70">$</span>
                        <span class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary-container shadow-sm" id="statRevenue">1,250</span>
                    </div>
                </div>
            </section>

            <!-- Main Interactive Section: Table & Chart Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter items-start">
                
                <!-- Live Queue Management Table -->
                <section class="lg:col-span-2 bg-surface/50 backdrop-blur-md border border-white/5 rounded-xl overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-surface-container-lowest/30">
                        <h2 class="font-headline-md text-headline-md text-on-surface">Live Queue</h2>
                        <button class="font-label-sm text-label-sm text-primary hover:text-gold-hover transition-colors flex items-center gap-1">
                            Refresh <span class="material-symbols-outlined text-[16px]" data-icon="refresh">refresh</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container/30">
                                    <th class="py-4 px-6 font-label-sm text-label-sm text-muted-gray uppercase tracking-widest font-normal">Client</th>
                                    <th class="py-4 px-6 font-label-sm text-label-sm text-muted-gray uppercase tracking-widest font-normal">Service</th>
                                    <th class="py-4 px-6 font-label-sm text-label-sm text-muted-gray uppercase tracking-widest font-normal">Status</th>
                                    <th class="py-4 px-6 font-label-sm text-label-sm text-muted-gray uppercase tracking-widest font-normal text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="font-body-md text-body-md divide-y divide-white/5" id="adminQueueTable">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Analytics Chart -->
                <section class="bg-surface/50 backdrop-blur-md border border-white/5 rounded-xl p-6 h-full flex flex-col">
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="font-headline-md text-headline-md text-on-surface">Weekly Trends</h2>
                        <span class="material-symbols-outlined text-muted-gray" data-icon="more_vert">more_vert</span>
                    </div>
                    <!-- Simplified CSS Bar Chart -->
                    <div class="flex-1 flex items-end gap-2 h-48 mt-auto pb-6 border-b border-white/5">
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[40%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">12</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">M</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[60%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">18</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">T</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[30%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">9</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">W</span>
                        </div>
                        <!-- Today -->
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-primary/80 rounded-t-sm transition-all duration-300 relative h-[80%] shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-100 transition-opacity" id="chartTodayVal">24</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-primary font-bold">T</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[90%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">28</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">F</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[100%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">32</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">S</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="w-full bg-surface-container rounded-t-sm transition-all duration-300 group-hover:bg-primary/50 relative h-[20%]">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-container-high text-on-surface font-label-sm px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">6</div>
                            </div>
                            <span class="font-label-sm text-label-sm text-muted-gray">S</span>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-center text-muted-gray">
                        <span class="font-label-sm text-label-sm">Total this week</span>
                        <span class="font-label-md text-label-md text-on-surface">129 Customers</span>
                    </div>
                </section>
            </div>
            
            <!-- Bottom spacing -->
            <div class="h-8"></div>
        </div>
    </main>

    <!-- Admin Logic -->
    <script src="js/admin.js"></script>
</body>
</html>
