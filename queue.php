<?php
// Initialize session if needed for future logic (e.g., membership points)
session_start();
?>
<!DOCTYPE html>
<html class="dark scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Booking & Queue - IF Barber</title>
    
    <!-- 1. Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- 2. Tailwind Configuration -->
    <script src="js/tailwind.config.js"></script>

    <!-- 3. Application Logic & Interactions -->
    <script src="js/app.js"></script>
    
    <!-- 4. Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- 5. Custom CSS Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col antialiased">
    
    <!-- TopNavBar -->
    <header class="bg-surface/70 dark:bg-surface/70 backdrop-blur-md fixed top-0 w-full z-50 border-b border-white/10 shadow-sm navbar-transition">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop h-20 max-w-container-max mx-auto">
            <a href="index.html" class="font-headline-md text-headline-md font-bold text-primary dark:text-primary tracking-tight cursor-pointer">
                IF Barber
            </a>
            
            <!-- Desktop Nav -->
            <nav class="hidden md:flex gap-gutter items-center">
                <a class="nav-link font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 transition-transform hover:text-gold-hover transition-all duration-300" href="index.html#services">Services</a>
                <a class="nav-link font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 transition-transform hover:text-gold-hover transition-all duration-300" href="index.html#barbers">Barbers</a>
                <a class="nav-link font-label-md text-label-md text-primary font-bold border-b-2 border-primary pb-1 cursor-pointer active:scale-95 transition-transform hover:text-gold-hover transition-all duration-300" href="queue.php">Queue</a>
            </nav>
            
            <button class="bg-primary-container text-on-primary font-label-md text-label-md px-6 py-3 rounded-DEFAULT hover:bg-gold-hover transition-colors cursor-pointer active:scale-95">
                Book Now
            </button>
            
            <!-- Mobile Menu Icon (Simplified for structure) -->
            <button class="md:hidden text-primary">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-[120px] pb-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full">
        
        <div class="mb-stack-lg">
            <h1 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl text-on-surface">Secure Your Seat</h1>
            <p class="font-body-lg text-body-lg text-muted-gray mt-2">Book an appointment or monitor the live queue.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
            
            <!-- Left Column: Booking Form (Bento/Card Style) -->
            <div class="lg:col-span-7 flex flex-col gap-stack-md">
                
                <!-- Client Info Card -->
                <div class="glass-panel rounded-xl p-stack-md">
                    <h2 class="font-headline-md text-headline-md text-primary mb-stack-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person</span> Client Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-sm">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-sm text-label-sm text-muted-gray ml-1">Full Name</label>
                            <input class="bg-surface-variant/50 border border-outline/30 focus:border-primary focus:ring-1 focus:ring-primary text-on-surface rounded-lg p-3 transition-colors outline-none font-body-md text-body-md placeholder:text-muted-gray/50" placeholder="John Doe" type="text" id="bName"/>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-sm text-label-sm text-muted-gray ml-1">Phone Number</label>
                            <input class="bg-surface-variant/50 border border-outline/30 focus:border-primary focus:ring-1 focus:ring-primary text-on-surface rounded-lg p-3 transition-colors outline-none font-body-md text-body-md placeholder:text-muted-gray/50" placeholder="+1 (555) 000-0000" type="tel" id="bPhone"/>
                        </div>
                    </div>
                </div>
                
                <!-- Service Selection Card -->
                <div class="glass-panel rounded-xl p-stack-md">
                    <h2 class="font-headline-md text-headline-md text-primary mb-stack-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">content_cut</span> Select Service
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-stack-sm" id="serviceOptions">
                        <!-- Service Option 1 (Active) -->
                        <label class="cursor-pointer relative rounded-lg p-4 border border-primary bg-primary/10 transition-all flex justify-between items-center group">
                            <input checked="" class="hidden" name="service" type="radio" value="Executive Haircut"/>
                            <div>
                                <div class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors">Executive Haircut</div>
                                <div class="font-label-sm text-label-sm text-muted-gray mt-1">45 mins</div>
                            </div>
                            <div class="font-label-md text-label-md text-primary">$45</div>
                        </label>
                        <!-- Service Option 2 -->
                        <label class="cursor-pointer relative rounded-lg p-4 border border-outline/30 hover:border-primary/50 bg-surface-variant/30 transition-all flex justify-between items-center group">
                            <input class="hidden" name="service" type="radio" value="Hair & Beard Trim"/>
                            <div>
                                <div class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors">Hair & Beard Trim</div>
                                <div class="font-label-sm text-label-sm text-muted-gray mt-1">60 mins</div>
                            </div>
                            <div class="font-label-md text-label-md text-on-surface-variant group-hover:text-primary transition-colors">$65</div>
                        </label>
                        <!-- Service Option 3 -->
                        <label class="cursor-pointer relative rounded-lg p-4 border border-outline/30 hover:border-primary/50 bg-surface-variant/30 transition-all flex justify-between items-center group">
                            <input class="hidden" name="service" type="radio" value="Hot Towel Shave"/>
                            <div>
                                <div class="font-label-md text-label-md text-on-surface group-hover:text-primary transition-colors">Hot Towel Shave</div>
                                <div class="font-label-sm text-label-sm text-muted-gray mt-1">30 mins</div>
                            </div>
                            <div class="font-label-md text-label-md text-on-surface-variant group-hover:text-primary transition-colors">$35</div>
                        </label>
                    </div>
                </div>
                
                <!-- Barber Selection Card -->
                <div class="glass-panel rounded-xl p-stack-md">
                    <h2 class="font-headline-md text-headline-md text-primary mb-stack-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">engineering</span> Choose Barber
                    </h2>
                    <div class="flex gap-4 overflow-x-auto no-scrollbar pb-2" id="barberOptions">
                        <!-- Barber 1 -->
                        <label class="cursor-pointer flex-shrink-0 w-32 rounded-lg border border-outline/30 hover:border-primary/50 bg-surface-variant/30 p-3 text-center transition-all group opacity-60 hover:opacity-100">
                            <input class="hidden" name="barber" type="radio" value="Marcus"/>
                            <div class="w-16 h-16 mx-auto rounded-full bg-surface-container-highest mb-3 overflow-hidden border-2 border-transparent group-hover:border-primary transition-colors">
                                <img alt="Barber portrait" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAao5temsF2yO-gEW3u6dNnBLMasBKWYw57m8jSap-SEle8jH_3QmCXZnJ8NEiFFVwfC3m7HQA4bPfk7JqGhhn4rbJVMIJ7o-qquhVb2X_5N-WS0ekC-qnrSx-kuz_adkUJYvjeoIoi1wwW7702G00I84czG7xXctrCKRWRvlk2Nh_RCWaKE_5IHSB6KhsemTu3ID1Nl3XeTUiMEvBsiJ6A2yLfzBAusXpfqyyWXRhzt36CfNNqGTKe5CBtDC0AkmxVVNc3QRTSea4u"/>
                            </div>
                            <div class="font-label-md text-label-md text-on-surface">Marcus</div>
                        </label>
                        <!-- Barber 2 (Active) -->
                        <label class="cursor-pointer flex-shrink-0 w-32 rounded-lg border border-primary bg-primary/10 p-3 text-center transition-all group">
                            <input checked="" class="hidden" name="barber" type="radio" value="Elias"/>
                            <div class="w-16 h-16 mx-auto rounded-full bg-surface-container-highest mb-3 overflow-hidden border-2 border-primary transition-colors">
                                <img alt="Barber portrait" class="w-full h-full object-cover filter grayscale-0 transition-all duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAPn4C6wudhAWRKeo6tvgHexf52v2dcrQveMrr9f7QwVw75yPOl10DK9egmlVMNs2McpBGC5SpNRu67DhsHi7H-h9RhFCSY9PQOhwBl2I6MKr16F7JJyZGUZKx8J_fG9SvhJTue582rfhx7_Sz4LXvrYbTuybYeksXMENtdYrh93ohVyyYTsFqwOf_maBY892JanX6aYRs7419Ldk63eHWxfii461eCi6HoBXWyCsm_jp1zpUVnl6X0Ju36RccJ1sCi-bO_FMxtlVv"/>
                            </div>
                            <div class="font-label-md text-label-md text-on-surface">Elias</div>
                        </label>
                        <!-- Barber 3 -->
                        <label class="cursor-pointer flex-shrink-0 w-32 rounded-lg border border-outline/30 hover:border-primary/50 bg-surface-variant/30 p-3 text-center transition-all group opacity-60 hover:opacity-100">
                            <input class="hidden" name="barber" type="radio" value="Any Available"/>
                            <div class="w-16 h-16 mx-auto rounded-full bg-surface-container-highest mb-3 overflow-hidden border-2 border-transparent group-hover:border-primary transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-muted-gray text-3xl">shuffle</span>
                            </div>
                            <div class="font-label-md text-label-md text-on-surface">Any Available</div>
                        </label>
                    </div>
                </div>
                
                <!-- Date & Time Card -->
                <div class="glass-panel rounded-xl p-stack-md mb-stack-md">
                    <div class="flex justify-between items-center mb-stack-sm">
                        <h2 class="font-headline-md text-headline-md text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">calendar_clock</span> Date & Time
                        </h2>
                        <div class="font-label-sm text-label-sm text-muted-gray">Today, Oct 24</div>
                    </div>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2" id="timeOptions">
                        <button class="py-2 border border-outline/30 rounded text-muted-gray font-label-md text-label-md bg-surface-container-lowest/50 cursor-not-allowed opacity-50" disabled="">10:00</button>
                        <button class="py-2 border border-outline/30 rounded text-muted-gray font-label-md text-label-md bg-surface-container-lowest/50 cursor-not-allowed opacity-50" disabled="">10:30</button>
                        <button class="py-2 border border-primary bg-primary/20 rounded text-primary font-label-md text-label-md hover:bg-primary/30 transition-colors time-btn" data-time="11:00">11:00</button>
                        <button class="py-2 border border-outline/30 rounded text-on-surface hover:border-primary hover:text-primary bg-surface-variant/30 transition-colors font-label-md text-label-md time-btn" data-time="11:30">11:30</button>
                        <button class="py-2 border border-outline/30 rounded text-on-surface hover:border-primary hover:text-primary bg-surface-variant/30 transition-colors font-label-md text-label-md time-btn" data-time="13:00">13:00</button>
                        <button class="py-2 border border-outline/30 rounded text-on-surface hover:border-primary hover:text-primary bg-surface-variant/30 transition-colors font-label-md text-label-md time-btn" data-time="14:00">14:00</button>
                    </div>
                </div>
                
                <!-- Submit Action -->
                <button id="submitBookingBtn" class="w-full bg-primary-container text-on-primary font-bold font-label-md text-label-md py-4 rounded-xl hover:bg-gold-hover hover:text-surface transition-all duration-300 shadow-[0_0_15px_rgba(212,175,55,0.2)] active:scale-[0.98]">
                    Confirm Reservation
                </button>
            </div>
            
            <!-- Right Column: Queue Dashboard (Sticky) -->
            <div class="lg:col-span-5 flex flex-col gap-stack-lg sticky top-28">
                
                <!-- Live Queue Card -->
                <div class="glass-panel rounded-xl p-stack-md glow-accent relative overflow-hidden">
                    <!-- Subtle background decoration -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <h2 class="font-headline-md text-headline-md text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                            Live Queue
                        </h2>
                        <span class="px-2 py-1 bg-error/10 text-error border border-error/20 rounded text-[10px] font-bold uppercase tracking-wider animate-pulse flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-error inline-block"></span> Live
                        </span>
                    </div>
                    
                    <!-- Now Serving -->
                    <div id="queueNowServing" class="bg-surface-container-lowest/50 border border-white/5 rounded-lg p-stack-sm mb-stack-md relative z-10">
                        <!-- Populated dynamically via JS -->
                        <div class="text-center py-4 text-muted-gray text-sm">Loading current serving...</div>
                    </div>
                    
                    <!-- Waitlist -->
                    <div class="relative z-10">
                        <div class="font-label-sm text-label-sm text-muted-gray mb-3 uppercase tracking-widest">Up Next</div>
                        <div id="queueWaitingList" class="flex flex-col gap-2">
                            <!-- Populated dynamically via JS -->
                            <div class="text-center py-4 text-muted-gray text-sm">Loading waitlist...</div>
                        </div>
                    </div>
                </div>
                
                <!-- Manage Booking / Search -->
                <div class="glass-panel rounded-xl p-stack-md">
                    <h3 class="font-label-md text-label-md text-on-surface mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-muted-gray text-lg">search</span> Manage Booking
                    </h3>
                    <p class="font-label-sm text-label-sm text-muted-gray mb-4">Enter your code to check status or cancel.</p>
                    <div class="flex gap-2">
                        <input id="searchCodeInput" class="flex-grow bg-surface-variant/50 border border-outline/30 focus:border-primary focus:ring-1 focus:ring-primary text-on-surface rounded-lg px-3 py-2 outline-none font-body-md text-body-md placeholder:text-muted-gray/50 uppercase" placeholder="e.g. BKN-892" type="text"/>
                        <button id="searchBookingBtn" class="bg-transparent border border-primary text-primary hover:bg-primary/10 transition-colors rounded-lg px-4 py-2 font-label-md text-label-md flex items-center justify-center">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-lowest dark:bg-surface-container-lowest w-full py-section-gap border-t border-white/5 mt-auto">
        <div class="flex flex-col md:flex-row justify-between items-start px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto gap-stack-lg">
            <div class="font-headline-md text-headline-md text-primary">
                IF Barber
            </div>
            <div class="flex flex-col gap-2 font-label-sm text-label-sm text-muted-gray">
                <a class="hover:text-primary transition-colors transition-opacity hover:opacity-80" href="#">Contact</a>
                <a class="hover:text-primary transition-colors transition-opacity hover:opacity-80" href="#">Instagram</a>
                <a class="hover:text-primary transition-colors transition-opacity hover:opacity-80" href="#">Facebook</a>
                <a class="hover:text-primary transition-colors transition-opacity hover:opacity-80" href="#">Hours</a>
            </div>
            <div class="font-body-md text-body-md text-muted-gray mt-4 md:mt-0">
                © 2024 IF Barber. Modern Prestige Grooming.
            </div>
        </div>
    </footer>

</body>
</html>
