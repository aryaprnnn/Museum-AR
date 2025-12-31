<x-admin-layout title="Dashboard">
    <div class="stats-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:32px;margin-bottom:36px;">
        <div class="stat-card">
            <h3>Total Blogs</h3>
            <p>{{ \App\Models\Blog::count() }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Collections</h3>
            <p>{{ \App\Models\Collection::count() }}</p>
        </div>
        <div class="stat-card">
            <h3>Art Classes</h3>
            <p>{{ \App\Models\ArtClass::count() }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Bookings (Paid)</h3>
            <p>{{ \App\Models\Booking::where('status', 'paid')->count() }}</p>
            <small style="color: #666;">Pending: {{ \App\Models\Booking::where('status', 'pending')->count() }}</small>
        </div>
        <div class="stat-card">
            <h3>Total Tiket</h3>
            <p>{{ \App\Models\Ticket::count() }}</p>
        </div>
    </div>
    @include('admin.dashboard-booking-chart')
    <style>
        .stat-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            padding: 32px 24px 24px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 140px;
        }
        .stat-card h3 {
            font-size: 1.1rem;
            color: #222;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .stat-card p {
            font-size: 2.3rem;
            font-weight: 700;
            color: #111;
            margin: 0;
        }
        @media(max-width:900px){.stats-grid{grid-template-columns:1fr 1fr;}}
        @media(max-width:600px){.stats-grid{grid-template-columns:1fr;}}
    </style>

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:16px;flex-wrap:wrap">
            <h2>Recent Bookings</h2>
            <div style="display:flex; gap:10px;">
                <select id="statusFilter" onchange="filterBookings()" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #ddd; outline: none; cursor: pointer;">
                    <option value="">Semua Status</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                </select>
                <div class="search-box">
                    <i class="fas fa-search" style="color:#999;font-size:0.9rem"></i>
                    <input type="text" id="bookingSearch" placeholder="Cari nama, email, kode..." onkeyup="filterBookings()">
                </div>
            </div>
        </div>
        <div class="table-container">
            <table id="bookingTable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>User</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Booking::with('user', 'bookable')->latest()->take(5)->get() as $booking)
                    <tr class="booking-row" 
                        data-search="{{ strtolower($booking->booking_code . ' ' . $booking->user->name . ' ' . $booking->user->email . ' ' . ($booking->bookable->title ?? '')) }}"
                        data-status="{{ strtolower($booking->status) }}">
                        <td>{{ $booking->booking_code }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->bookable->title ?? 'N/A' }}</td>
                        <td>
                            @php
                                $bookingBg = in_array($booking->status, ['paid', 'confirmed']) ? '#28a745' : ($booking->status == 'pending' ? '#ffc107' : '#dc3545');
                            @endphp
                            <span style="background:{{ $bookingBg }};color:#fff;padding:4px 8px;border-radius:4px;font-size:0.85rem;font-weight:600;">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </td>
                        <td>{{ $booking->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:#999">No bookings yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function filterBookings() {
        const searchText = document.getElementById('bookingSearch').value.toLowerCase();
        const statusValue = document.getElementById('statusFilter').value.toLowerCase();
        const rows = document.querySelectorAll('.booking-row');

        rows.forEach(row => {
            const rowSearchData = row.getAttribute('data-search');
            const rowStatus = row.getAttribute('data-status');
            const matchesSearch = rowSearchData.includes(searchText);
            const matchesStatus = statusValue === "" || rowStatus === statusValue;
            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    </script>

    <div class="card" style="margin-top:32px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:16px;flex-wrap:wrap">
            <h2>Recent Tickets</h2>
        </div>
        <div class="table-container">
            <table id="ticketTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Status</th>
                        <th>Exhibition</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Ticket::with('exhibition')->latest()->take(5)->get() as $ticket)
                    <tr>
                        <td>{{ $ticket->order_id }}</td>
                        <td>{{ $ticket->email }}</td>
                        <td>{{ $ticket->phone }}</td>
                        <td>
                            @php
                                $bg = $ticket->status == 'paid' ? '#28a745' : ($ticket->status == 'pending' ? '#ffc107' : '#6c757d');
                            @endphp
                            <span style="background:{{ $bg }};color:#fff;padding:4px 8px;border-radius:4px;font-size:0.85rem">{{ $ticket->status }}</span>
                        </td>
                        <td>{{ $ticket->exhibition->title ?? '-' }}</td>
                        <td>{{ $ticket->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:#999">No tickets yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
