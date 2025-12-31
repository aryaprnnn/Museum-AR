<x-admin-layout title="Registered Users">
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:16px;flex-wrap:wrap">
            <h2><i class="fas fa-users"></i> Registered Users</h2>
            <div class="search-box">
                <i class="fas fa-search" style="color:#999;font-size:0.9rem"></i>
                <input type="text" id="userSearch" placeholder="Search by name, email, phone..." onkeyup="filterUsers()">
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Registered Date</th>
                        <th>Total Bookings</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="user-row" data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . ($user->whatsapp ?? '')) }}">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->whatsapp ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td><span style="background:#f0f0f0;padding:4px 8px;border-radius:4px;font-weight:600">{{ $user->bookings->count() }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:#999">No users registered yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function filterUsers() {
        const input = document.getElementById('userSearch');
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');
        
        rows.forEach(row => {
            const searchText = row.getAttribute('data-search');
            if (searchText.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    </script>
</x-admin-layout>
