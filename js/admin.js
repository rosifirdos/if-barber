/* ----------------------------------------------------
   IF Barber - Admin Dashboard Logic
   ---------------------------------------------------- */

document.addEventListener('DOMContentLoaded', () => {
    
    // Elements
    const adminQueueTable = document.getElementById('adminQueueTable');
    const statTodayQueue = document.getElementById('statTodayQueue');
    const chartTodayVal = document.getElementById('chartTodayVal');
    const statPopularService = document.getElementById('statPopularService');
    const statPopularCount = document.getElementById('statPopularCount');
    const statRevenue = document.getElementById('statRevenue');

    // Fetch data from localStorage
    function getBookings() {
        return JSON.parse(localStorage.getItem('if_barber_bookings')) || [];
    }

    function saveBookings(bookings) {
        localStorage.setItem('if_barber_bookings', JSON.stringify(bookings));
        renderDashboard();
    }

    // Main render function
    function renderDashboard() {
        const bookings = getBookings();
        
        // --- 1. Compute Stats ---
        // We assume all bookings in localStorage are for "today" in this simple prototype
        const todayBookings = bookings;
        
        statTodayQueue.innerText = todayBookings.length;
        if (chartTodayVal) chartTodayVal.innerText = todayBookings.length;

        // Compute Popular Service
        const serviceCounts = {};
        let popularSvc = "N/A";
        let maxCount = 0;
        
        // Compute Revenue (extract numbers from string like "Classic Cut ($65)")
        let revenue = 0;

        todayBookings.forEach(b => {
            // Count popular
            serviceCounts[b.service] = (serviceCounts[b.service] || 0) + 1;
            if (serviceCounts[b.service] > maxCount) {
                maxCount = serviceCounts[b.service];
                popularSvc = b.service;
            }

            // Simple revenue calculation (based on base prices)
            if (b.status === 'completed' || b.status === 'in_progress') {
                if (b.service.includes('Classic Cut')) revenue += 65;
                else if (b.service.includes('Luxury Hot Shave')) revenue += 55;
                else if (b.service.includes('Executive Package')) revenue += 110;
            }
        });

        statPopularService.innerText = popularSvc;
        statPopularCount.innerText = `${maxCount} bookings today`;
        statRevenue.innerText = revenue.toLocaleString();

        // --- 2. Render Queue Table ---
        if (!adminQueueTable) return;
        adminQueueTable.innerHTML = '';

        if (todayBookings.length === 0) {
            adminQueueTable.innerHTML = `
                <tr>
                    <td colspan="4" class="py-8 text-center text-on-surface-variant">Belum ada antrean hari ini.</td>
                </tr>
            `;
            return;
        }

        // Sort: in_progress first, then waiting, then completed
        const statusOrder = { 'in_progress': 1, 'waiting': 2, 'completed': 3, 'cancelled': 4 };
        const sortedBookings = [...todayBookings].sort((a, b) => {
            if (statusOrder[a.status] !== statusOrder[b.status]) {
                return statusOrder[a.status] - statusOrder[b.status];
            }
            return a.queue - b.queue;
        });

        sortedBookings.forEach(booking => {
            // Initials helper
            const initials = booking.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            
            // Status styling
            let statusBadge = '';
            let actionHtml = '';

            if (booking.status === 'waiting') {
                statusBadge = `
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-status-waiting/10 text-status-waiting border border-status-waiting/20">
                        Waiting
                    </span>
                `;
                actionHtml = `
                    <button onclick="updateStatus('${booking.code}', 'in_progress')" class="px-4 py-2 rounded bg-status-progress/10 text-status-progress border border-status-progress/30 hover:bg-status-progress/20 transition-colors font-label-sm text-label-sm flex items-center gap-2 ml-auto">
                        <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                        Mulai Cukur
                    </button>
                `;
            } else if (booking.status === 'in_progress') {
                statusBadge = `
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-status-progress/10 text-status-progress border border-status-progress/20">
                        Serving
                    </span>
                `;
                actionHtml = `
                    <button onclick="updateStatus('${booking.code}', 'completed')" class="px-4 py-2 rounded bg-status-completed/10 text-status-completed border border-status-completed/30 hover:bg-status-completed/20 transition-colors font-label-sm text-label-sm flex items-center gap-2 ml-auto">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        Selesai
                    </button>
                `;
            } else if (booking.status === 'completed') {
                statusBadge = `
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-highest text-muted-gray border border-white/10">
                        Finished
                    </span>
                `;
                actionHtml = `
                    <button class="p-2 rounded text-muted-gray hover:text-on-surface hover:bg-surface-container transition-colors inline-flex ml-auto" title="Print Receipt">
                        <span class="material-symbols-outlined">picture_as_pdf</span>
                    </button>
                `;
            }

            const trClass = booking.status === 'in_progress' ? 'bg-surface-container-lowest/20' : '';
            const nameClass = booking.status === 'completed' ? 'text-muted-gray line-through decoration-white/20' : 'text-on-surface';

            adminQueueTable.innerHTML += `
                <tr class="hover:bg-surface-container-low/50 transition-colors ${trClass}">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high border border-white/10 flex items-center justify-center text-on-surface font-label-md">
                                ${initials}
                            </div>
                            <span class="${nameClass}">#${booking.queue} - ${booking.name}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        <div class="flex flex-col">
                            <span>${booking.service}</span>
                            <span class="text-xs text-muted-gray">By: ${booking.barber}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        ${statusBadge}
                    </td>
                    <td class="py-4 px-6 text-right">
                        ${actionHtml}
                    </td>
                </tr>
            `;
        });
    }

    // Global function for action buttons
    window.updateStatus = function(code, newStatus) {
        let bookings = getBookings();
        const bIndex = bookings.findIndex(b => b.code === code);
        if (bIndex > -1) {
            bookings[bIndex].status = newStatus;
            saveBookings(bookings);
            // Alert simple
            if(newStatus === 'in_progress') alert('Status diubah: Mulai Cukur!');
            if(newStatus === 'completed') alert('Status diubah: Cukur Selesai!');
        }
    };

    // Initial render
    renderDashboard();

    // Refresh button event listener
    const refreshBtn = document.querySelector('button:has(span[data-icon="refresh"])');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', renderDashboard);
    }
});
