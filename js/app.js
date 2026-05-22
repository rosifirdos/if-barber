/* ----------------------------------------------------
   IF Barber - Application Logic
   Modern Prestige Grooming Aesthetics
   ---------------------------------------------------- */

// Initialize App Script Interactions on DOM Loaded
document.addEventListener('DOMContentLoaded', () => {
    
    // --- Mock Database for Booking & Queue ---
    const initialBookings = [
        { code: 'BFK-101', name: 'Alexander Smith', phone: '08123456789', service: 'The Classic Cut', barber: 'Marcus Vance', time: '14:30', queue: 14, status: 'completed' },
        { code: 'BFK-102', name: 'David Beckham', phone: '08129876543', service: 'The Executive Package', barber: 'Julian Thorne', time: '15:15', queue: 15, status: 'in_progress' },
        { code: 'BFK-103', name: 'Jonathan Doe', phone: '08112233445', service: 'Luxury Hot Shave', barber: 'Elena Rostova', time: '16:00', queue: 16, status: 'waiting' },
        { code: 'BFK-104', name: 'Michael Carver', phone: '08998877665', service: 'The Classic Cut', barber: 'Marcus Vance', time: '16:45', queue: 17, status: 'waiting' }
    ];

    // LocalStorage or In-Memory Session Storage for persistence
    let bookingsDb = JSON.parse(localStorage.getItem('if_barber_bookings')) || initialBookings;
    
    function saveBookings() {
        localStorage.setItem('if_barber_bookings', JSON.stringify(bookingsDb));
        renderQueueList();
    }

    // --- UI Elements Selector ---
    const navBar = document.querySelector('nav');
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section, main > section');
    const bookButtons = document.querySelectorAll('.btn-book-trigger');
    
    // Modal Booking Elements
    const bookingModal = document.getElementById('bookingModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const bookingForm = document.getElementById('bookingForm');
    const successResult = document.getElementById('successResult');
    
    // Chatbot Elements
    const chatFabBtn = document.getElementById('chatFabBtn');
    const chatWindow = document.getElementById('chatWindow');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const chatInput = document.getElementById('chatInput');
    const chatSendBtn = document.getElementById('chatSendBtn');
    const chatMessages = document.getElementById('chatMessages');

    // --- 1. Navbar Scroll Transition ---
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navBar.classList.add('navbar-scrolled');
        } else {
            navBar.classList.remove('navbar-scrolled');
        }
        updateActiveNavLink();
    });

    // --- 2. Active Link Highlighting & Smooth Scroll ---
    function updateActiveNavLink() {
        let currentSectionId = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 120; // offset navbar height
            const sectionHeight = section.offsetHeight;
            if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                currentSectionId = section.getAttribute('id') || '';
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('text-primary', 'border-b-2', 'border-primary', 'pb-1');
            link.classList.add('text-on-surface-variant');
            
            const href = link.getAttribute('href');
            if (href === '#' + currentSectionId || (href === '#' && !currentSectionId)) {
                link.classList.add('text-primary', 'border-b-2', 'border-primary', 'pb-1');
                link.classList.remove('text-on-surface-variant');
            }
        });
    }

    // Smooth Scroll to Anchor Links
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                
                if (href === '#') {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }
                
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    const navbarOffset = 80;
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navbarOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // --- 3. Dynamic Rendering of Real-time Queue Status ---
    function renderQueueList() {
        const currentServingContainer = document.getElementById('currentServingQueue');
        const waitingListContainer = document.getElementById('waitingListQueue');
        
        if (!currentServingContainer || !waitingListContainer) return;

        // Clear previous entries
        currentServingContainer.innerHTML = '';
        waitingListContainer.innerHTML = '';

        // Filter and display current serving (status 'in_progress')
        const activeBookings = bookingsDb.filter(b => b.status === 'in_progress');
        if (activeBookings.length > 0) {
            activeBookings.forEach(booking => {
                currentServingContainer.innerHTML += `
                    <div class="flex items-center justify-between p-4 rounded-lg bg-primary/10 border border-primary/20">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center font-headline-md text-primary font-bold">
                                #${booking.queue}
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">${booking.name}</h4>
                                <p class="text-xs text-on-surface-variant">Barber: ${booking.barber} | ${booking.service}</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#2196F3]/20 text-[#2196F3] border border-[#2196F3]/30 animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-[#2196F3]"></span>
                            Serving
                        </span>
                    </div>
                `;
            });
        } else {
            currentServingContainer.innerHTML = `
                <div class="p-6 text-center text-on-surface-variant font-body-md glass-panel rounded-lg">
                    Tidak ada antrean yang sedang berjalan.
                </div>
            `;
        }

        // Filter and display waiting (status 'waiting')
        const waitingBookings = bookingsDb.filter(b => b.status === 'waiting');
        if (waitingBookings.length > 0) {
            waitingBookings.forEach(booking => {
                waitingListContainer.innerHTML += `
                    <div class="flex items-center justify-between p-4 rounded-lg bg-surface-container-high border border-white/5 hover:border-white/10 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-on-surface-variant">
                                #${booking.queue}
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">${booking.name}</h4>
                                <p class="text-xs text-on-surface-variant">Barber: ${booking.barber} | ${booking.service}</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FFC107]/20 text-[#FFC107] border border-[#FFC107]/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#FFC107]"></span>
                            Waiting
                        </span>
                    </div>
                `;
            });
        } else {
            waitingListContainer.innerHTML = `
                <div class="p-6 text-center text-on-surface-variant font-body-md glass-panel rounded-lg">
                    Semua antrean hari ini telah selesai dicukur!
                </div>
            `;
        }
        const queueNowServing = document.getElementById('queueNowServing');
        const queueWaitingList = document.getElementById('queueWaitingList');
        if (queueNowServing && queueWaitingList) {
            queueNowServing.innerHTML = '';
            queueWaitingList.innerHTML = '';

            const activeBookings = bookingsDb.filter(b => b.status === 'in_progress');
            if (activeBookings.length > 0) {
                const booking = activeBookings[0];
                queueNowServing.innerHTML = `
                    <div class="font-label-sm text-label-sm text-muted-gray mb-1 uppercase tracking-widest">Now Serving</div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary leading-none">#${booking.queue}</div>
                            <div class="font-label-md text-label-md text-on-surface mt-1">${booking.name}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-label-sm text-label-sm text-muted-gray">Barber</div>
                            <div class="font-label-md text-label-md text-on-surface">${booking.barber}</div>
                        </div>
                    </div>
                `;
            } else {
                queueNowServing.innerHTML = `<div class="text-center py-4 text-muted-gray text-sm">Tidak ada antrean yang sedang berjalan.</div>`;
            }

            const waitingBookings = bookingsDb.filter(b => b.status === 'waiting');
            if (waitingBookings.length > 0) {
                waitingBookings.forEach((booking, index) => {
                    const waitTime = index * 25 + 5; // roughly
                    queueWaitingList.innerHTML += `
                    <div class="flex items-center justify-between p-3 bg-surface-variant/20 rounded border border-white/5 hover:bg-surface-variant/40 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="font-headline-md text-headline-md text-on-surface-variant w-8">#${booking.queue}</div>
                            <div>
                                <div class="font-label-md text-label-md text-on-surface">${booking.name}</div>
                                <div class="font-label-sm text-label-sm text-muted-gray">with ${booking.barber}</div>
                            </div>
                        </div>
                        <span class="bg-status-waiting/10 text-status-waiting px-2 py-1 rounded text-xs font-medium">~${waitTime} mins</span>
                    </div>
                    `;
                });
            } else {
                queueWaitingList.innerHTML = `<div class="text-center py-4 text-muted-gray text-sm">Semua antrean telah selesai.</div>`;
            }
        }
    }

    // Initial render of queue
    renderQueueList();

    // --- 4. Modal Booking Logic ---
    function openModal() {
        bookingModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Lock background scroll
        // Reset modal states
        bookingForm.classList.remove('hidden');
        successResult.classList.add('hidden');
        
        // Auto-fill date with today (Indonesia timezone offset conversion helper)
        const today = new Date();
        const dateInput = document.getElementById('booking_date');
        if (dateInput) {
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            dateInput.value = `${year}-${month}-${day}`;
            dateInput.min = `${year}-${month}-${day}`; // prevent selecting past dates
        }
    }

    function closeModal() {
        bookingModal.classList.add('hidden');
        document.body.style.overflow = ''; // Release scroll
    }

    // Bind triggers to show booking modal
    bookButtons.forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    closeModalBtn.addEventListener('click', closeModal);
    bookingModal.addEventListener('click', (e) => {
        if (e.target === bookingModal) closeModal();
    });

    // Handle Form Submission
    bookingForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Extract form values
        const name = document.getElementById('customer_name').value;
        const phone = document.getElementById('customer_phone').value;
        const serviceSelect = document.getElementById('service_id');
        const serviceName = serviceSelect.options[serviceSelect.selectedIndex].text.split(' - ')[0];
        const servicePrice = serviceSelect.options[serviceSelect.selectedIndex].text.split(' - ')[1];
        
        const barberSelect = document.getElementById('barber_id');
        const barberName = barberSelect.options[barberSelect.selectedIndex].text;
        const date = document.getElementById('booking_date').value;
        const time = document.getElementById('booking_time').value;

        // Generate Booking Code & Queue Number
        const randomStr = Math.random().toString(36).substring(2, 6).toUpperCase();
        const bookingCode = `BFK-${randomStr}`;
        
        // Simple queue numbering logic: take the max queue of today and add 1
        const queuesToday = bookingsDb.map(b => b.queue);
        const nextQueueNum = queuesToday.length > 0 ? Math.max(...queuesToday) + 1 : 1;

        // Create new booking object
        const newBooking = {
            code: bookingCode,
            name: name,
            phone: phone,
            service: serviceName,
            barber: barberName,
            date: date,
            time: time,
            queue: nextQueueNum,
            status: 'waiting'
        };

        // Push and Save
        bookingsDb.push(newBooking);
        saveBookings();

        // Show Success Result Screen
        renderSuccessBooking(newBooking, servicePrice);
    });

    function renderSuccessBooking(booking, price) {
        bookingForm.classList.add('hidden');
        successResult.classList.remove('hidden');

        // Populate details
        document.getElementById('resQueueNumber').innerText = `#${booking.queue}`;
        document.getElementById('resBookingCode').innerText = booking.code;
        document.getElementById('resCustomer').innerText = booking.name;
        document.getElementById('resBarber').innerText = booking.barber;
        document.getElementById('resService').innerText = `${booking.service} (${price})`;
        document.getElementById('resSchedule').innerText = `${booking.date} @ ${booking.time}`;
    }

    // Close success panel helper button
    window.closeSuccessPanel = function() {
        closeModal();
        // Automatically scroll to the queue status section so user sees their item
        const queueSection = document.getElementById('queue');
        if (queueSection) {
            queueSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    // --- 5. AI Chatbot Widget (Gemini Mock Interface) ---
    function toggleChat() {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            chatInput.focus();
            // Scroll to bottom of chat
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    chatFabBtn.addEventListener('click', toggleChat);
    closeChatBtn.addEventListener('click', toggleChat);

    // Bot Response Logic
    function getBotResponse(userText) {
        const text = userText.toLowerCase();

        // 1. Check for Booking Queue Status Search
        // Matches "BFK-XXXX" or "cek status BFK-XXXX" or "status BFK-XXXX"
        const bookingMatch = text.match(/bfk-[a-z0-9]+/i);
        if (bookingMatch) {
            const searchCode = bookingMatch[0].toUpperCase();
            const foundBooking = bookingsDb.find(b => b.code === searchCode);

            if (foundBooking) {
                // Calculate wait time (each waiting person takes ~30 mins)
                const waitingList = bookingsDb.filter(b => b.status === 'waiting');
                const indexOfMe = waitingList.findIndex(b => b.code === searchCode);
                
                let statusText = 'Antre (Waiting)';
                let statusDetails = '';

                if (foundBooking.status === 'completed') {
                    statusText = 'Selesai (Completed)';
                    statusDetails = 'Layanan Anda telah selesai dicukur. Terima kasih telah berkunjung!';
                } else if (foundBooking.status === 'in_progress') {
                    statusText = 'Sedang Dicukur (In Progress)';
                    statusDetails = `Anda sedang berada di kursi cukur bersama barber ${foundBooking.barber}.`;
                } else if (foundBooking.status === 'cancelled') {
                    statusText = 'Dibatalkan (Cancelled)';
                    statusDetails = 'Booking ini telah dibatalkan.';
                } else {
                    // Waiting
                    const currentServing = bookingsDb.find(b => b.status === 'in_progress');
                    const servingText = currentServing ? `#${currentServing.queue}` : 'Tidak ada';
                    const peopleAhead = indexOfMe >= 0 ? indexOfMe : waitingList.length;
                    const waitTime = peopleAhead * 25;

                    statusDetails = `
                        Status: **${statusText}**<br>
                        Nomor Antrean Anda: **#${foundBooking.queue}**<br>
                        Sedang Dicukur Saat Ini: **${servingText}**<br>
                        Antrean di Depan Anda: **${peopleAhead} orang**<br>
                        Estimasi Waktu Tunggu: **±${waitTime} menit**
                    `;
                }

                return `
                    <strong>Kode Booking Terdeteksi!</strong><br>
                    Detail Pemesanan:<br>
                    • Nama: ${foundBooking.name}<br>
                    • Layanan: ${foundBooking.service}<br>
                    • Barber: ${foundBooking.barber}<br>
                    • Jadwal: ${foundBooking.date} pukul ${foundBooking.time}<br>
                    <br>
                    ${statusDetails}
                `;
            } else {
                return `Maaf, saya tidak menemukan data antrean untuk kode booking <strong>${searchCode}</strong>. Harap pastikan kode yang Anda masukkan benar (contoh format: BFK-103 atau kode kustom Anda).`;
            }
        }

        // 2. FAQ - Services / Layanan
        if (text.includes('layanan') || text.includes('service') || text.includes('menu') || text.includes('harga') || text.includes('cukur')) {
            return `
                Berikut adalah menu layanan unggulan kami di <strong>IF Barber</strong>:
                <br><br>
                1. <strong>The Classic Cut ($65)</strong>: Potong rambut presisi, cuci rambut, styling, dan pijat handuk hangat.
                <br>
                2. <strong>Luxury Hot Shave ($55)</strong>: Cukur jenggot/kumis tradisional menggunakan pisau lurus, minyak esensial premium, dan handuk hangat.
                <br>
                3. <strong>The Executive Package ($110)</strong>: Paket lengkap potongan rambut klasik dan cukur mewah dengan pijat kulit kepala eksklusif.
                <br><br>
                Anda bisa melakukan booking langsung dengan mengklik tombol <strong>Book Now</strong> di bagian atas halaman!
            `;
        }

        // 3. FAQ - Barbers
        if (text.includes('barber') || text.includes('tukang cukur') || text.includes('kapster') || text.includes('pemotong')) {
            return `
                Kami memiliki 3 Barber Master bersertifikat yang siap melayani Anda:
                <br><br>
                • <strong>Marcus Vance</strong> (Spesialisasi: Master Fade, Scissor Work) - Ahli potong rambut bergradasi tajam dan teknik gunting klasik.
                <br>
                • <strong>Julian Thorne</strong> (Spesialisasi: Beard Specialist) - Ahli merapikan jenggot, kumis, dan cukuran tajam klasik.
                <br>
                • <strong>Elena Rostova</strong> (Spesialisasi: Classic Styling) - Ahli gaya rambut kasual, formal, dan perawatan rambut premium.
            `;
        }

        // 4. FAQ - Hours & Location
        if (text.includes('jam') || text.includes('buka') || text.includes('tutup') || text.includes('lokasi') || text.includes('alamat') || text.includes('hari')) {
            return `
                <strong>IF Barber | Modern Prestige Grooming</strong>
                <br><br>
                📅 <strong>Jam Operasional:</strong><br>
                Senin - Minggu: 10:00 - 21:00 WIB
                <br><br>
                📍 <strong>Lokasi Kami:</strong><br>
                Jl. Prestige No. 12, Area Eksklusif, Jakarta Selatan.
                <br><br>
                Silakan datang sesuai dengan jadwal booking Anda untuk menghindari keterlambatan.
            `;
        }

        // 5. General Greeting & Fallback
        return `
            Halo! Saya adalah AI Assistant IF Barber. 🤖✨
            <br><br>
            Ada yang bisa saya bantu? Anda dapat bertanya tentang:
            <br>
            • 💰 <strong>Harga & Layanan</strong>
            <br>
            • 💈 <strong>Profil Barber Master kami</strong>
            <br>
            • 📅 <strong>Jam Operasional & Alamat</strong>
            <br>
            • 🔍 <strong>Cek Status Antrean</strong> (Ketikkan kode booking Anda, misal: <code>BFK-103</code>)
        `;
    }

    // Append Message to UI Helper
    function appendMessage(sender, text) {
        const isUser = sender === 'user';
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex ${isUser ? 'justify-end' : 'justify-start'} mb-4`;
        
        msgDiv.innerHTML = `
            <div class="${isUser ? 'bg-primary text-on-primary rounded-br-none' : 'bg-surface-container-high text-on-surface rounded-bl-none'} max-w-[80%] rounded-2xl px-4 py-2.5 text-sm shadow-md leading-relaxed">
                ${text}
            </div>
        `;
        
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send Message Trigger
    function handleSendMessage() {
        const text = chatInput.value.trim();
        if (!text) return;

        // Append User message
        appendMessage('user', text);
        chatInput.value = '';

        // Show typing indicator
        const typingIndicator = document.createElement('div');
        typingIndicator.id = 'typingIndicator';
        typingIndicator.className = 'flex justify-start mb-4';
        typingIndicator.innerHTML = `
            <div class="bg-surface-container-high text-on-surface rounded-2xl rounded-bl-none max-w-[80%] px-4 py-2.5 text-sm shadow-md flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay: 300ms"></span>
            </div>
        `;
        chatMessages.appendChild(typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Simulate network delay for AI response
        setTimeout(() => {
            // Remove typing indicator
            const indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();

            // Get bot response and append
            const botResponse = getBotResponse(text);
            appendMessage('bot', botResponse);
        }, 1200);
    }

    // Event listeners for chat actions
    chatSendBtn.addEventListener('click', handleSendMessage);
    chatInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            handleSendMessage();
        }
    });

    // --- 6. Queue Page Logic ---
    const submitBookingBtn = document.getElementById('submitBookingBtn');
    if (submitBookingBtn) {
        // Service Selection Styling Logic
        const serviceRadios = document.querySelectorAll('input[name="service"]');
        serviceRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('input[name="service"]').forEach(r => {
                    const parent = r.closest('label');
                    parent.classList.remove('border-primary', 'bg-primary/10');
                    parent.classList.add('border-outline/30', 'bg-surface-variant/30');
                });
                if (radio.checked) {
                    const parent = radio.closest('label');
                    parent.classList.add('border-primary', 'bg-primary/10');
                    parent.classList.remove('border-outline/30', 'bg-surface-variant/30');
                }
            });
        });

        // Barber Selection Styling Logic
        const barberRadios = document.querySelectorAll('input[name="barber"]');
        barberRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('input[name="barber"]').forEach(r => {
                    const parent = r.closest('label');
                    parent.classList.remove('border-primary', 'bg-primary/10');
                    parent.classList.add('border-outline/30', 'bg-surface-variant/30', 'opacity-60');
                    const imgBorder = parent.querySelector('.rounded-full');
                    if(imgBorder) imgBorder.classList.remove('border-primary');
                    if(imgBorder) imgBorder.classList.add('border-transparent');
                    const img = parent.querySelector('img');
                    if(img) img.classList.add('grayscale');
                });
                if (radio.checked) {
                    const parent = radio.closest('label');
                    parent.classList.add('border-primary', 'bg-primary/10');
                    parent.classList.remove('border-outline/30', 'bg-surface-variant/30', 'opacity-60');
                    const imgBorder = parent.querySelector('.rounded-full');
                    if(imgBorder) imgBorder.classList.add('border-primary');
                    if(imgBorder) imgBorder.classList.remove('border-transparent');
                    const img = parent.querySelector('img');
                    if(img) img.classList.remove('grayscale');
                }
            });
        });

        // Time selection logic
        const timeBtns = document.querySelectorAll('.time-btn');
        let selectedTime = '11:00';
        timeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                timeBtns.forEach(b => {
                    b.classList.remove('border-primary', 'bg-primary/20', 'text-primary');
                    b.classList.add('border-outline/30', 'text-on-surface', 'bg-surface-variant/30');
                });
                btn.classList.add('border-primary', 'bg-primary/20', 'text-primary');
                btn.classList.remove('border-outline/30', 'text-on-surface', 'bg-surface-variant/30');
                selectedTime = btn.getAttribute('data-time');
            });
        });

        submitBookingBtn.addEventListener('click', () => {
            const name = document.getElementById('bName').value;
            const phone = document.getElementById('bPhone').value;
            const serviceEl = document.querySelector('input[name="service"]:checked');
            const barberEl = document.querySelector('input[name="barber"]:checked');
            
            if (!name || !phone || !serviceEl || !barberEl) {
                alert('Silakan lengkapi data booking Anda.');
                return;
            }

            const serviceName = serviceEl.value;
            const barberName = barberEl.value;
            
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const date = `${year}-${month}-${day}`;

            const randomStr = Math.random().toString(36).substring(2, 6).toUpperCase();
            const bookingCode = `BFK-${randomStr}`;
            
            const queuesToday = bookingsDb.map(b => b.queue);
            const nextQueueNum = queuesToday.length > 0 ? Math.max(...queuesToday) + 1 : 1;

            const newBooking = {
                code: bookingCode,
                name: name,
                phone: phone,
                service: serviceName,
                barber: barberName,
                date: date,
                time: selectedTime,
                queue: nextQueueNum,
                status: 'waiting'
            };

            bookingsDb.push(newBooking);
            saveBookings();
            
            alert(`Booking Berhasil!\nKode: ${bookingCode}\nNomor Antrean: #${nextQueueNum}`);
            
            // Reset
            document.getElementById('bName').value = '';
            document.getElementById('bPhone').value = '';
        });
    }

    const searchBookingBtn = document.getElementById('searchBookingBtn');
    if (searchBookingBtn) {
        searchBookingBtn.addEventListener('click', () => {
            const code = document.getElementById('searchCodeInput').value.trim().toUpperCase();
            if (!code) return;
            const found = bookingsDb.find(b => b.code === code);
            if (found) {
                alert(`Booking Ditemukan:\nNama: ${found.name}\nStatus: ${found.status}\nAntrean: #${found.queue}`);
            } else {
                alert('Kode booking tidak ditemukan.');
            }
        });
    }

});
