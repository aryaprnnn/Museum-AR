<x-admin-layout title="Daftar Tiket">
    <h2 style="margin-bottom:24px;">Daftar Tiket Exhibition</h2>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Exhibition</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->order_id }}</td>
                    <td>{{ $ticket->exhibition->title ?? '-' }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td>
                        <span class="badge 
                            @if($ticket->status == 'paid' || $ticket->status == 'confirmed') badge-success
                            @elseif($ticket->status == 'pending') badge-warning
                            @else badge-secondary
                            @endif">
                            {{ ($ticket->status == 'paid' || $ticket->status == 'confirmed') ? 'Confirmed' : ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada tiket</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:18px;">
            {{ $tickets->links() }}
        </div>
    </div>
</x-admin-layout>
